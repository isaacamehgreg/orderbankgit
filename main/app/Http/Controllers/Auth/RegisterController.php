<?php

namespace App\Http\Controllers\Auth;

use App\Models\Referral;
use App\User;
use App\Wallet;
use App\Business;
use App\Subscriptions;
use App\WalletHistory;
use Illuminate\Http\Request;
use App\BusinessSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/reports';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'businuss_phone_number' => ['required', 'string', 'business_phone_number', 'max:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'business_name' => $data['business_name'],
            'business_phone_number' => $data['business_phone_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function index(Request $request) {
        $referrer = $request->get('r');
        if ($referrer != "") {
            session()->put('r', $referrer);
        }
        return view('signup');
    }

    public function post(Request $request) {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'business_name' => ['required'],
            'email' => ['required', 'unique:users,email_address'],
            'address' => ['required'],
            'business_phone_number' => ['unique:users,business_phone_number'],
            'pass' => ['required']
        ]);
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $business_name = $request->business_name;
        $business_phone_number =$request->business_phone_number;
        $email = $request->email;
        $pass = $request->pass;

        // setup user
        $user = new User();
        $user->role = 1;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->business_phone_number = $business_phone_number;
        $user->business_name = $business_name;
        $user->email_address = $email;
        $user->password = Hash::make($pass);
        $user->orders_count = 20;
        $user->save();

        $business = new Business();
        $business->user_id = $user->id;
        $business->firstname = $request->first_name;
        $business->_lastname = $request->last_name;
        $business->business_name = $request->business_name;
        $business->business_address = $request->address;
        $business->business_phone_number = $request->business_phone_number;
        $business->business_email = $request->email;
        $business->save();

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->balance = 100;
        $wallet->save();

        $wallet_history = new WalletHistory();
        $wallet_history->user_id = $user->id;
        $wallet_history->amount = 100;
        $wallet_history->status = Wallet::STATUS_SUCCESSFUL;
        $wallet_history->reference = 'FREE';
        $wallet_history->type = 'credit';
        $wallet_history->save();

        $plan = Subscriptions::find(1);
        $renewalDate = strtotime("+1 month", time());

        BusinessSubscription::where('user_id', $user->id)->delete();

        $subscription = new BusinessSubscription([
            'business_id' => 0,
            'user_id' => $user->id,
            'subscription_id' => BusinessSubscription::BASIC_PLAN_ID,
            'start_at' => time(),
            'end_at' => $renewalDate,
            'payload' => null
        ]);

        $subscription->save();

        $code = session()->get('r');
        if ($code != null) {
            try {
                $referrer = User::where('referral_code', $code)->first();
                if ($referrer != null) {
                    Referral::create([
                        'user_id' => $user->id,
                        'referrer_id' => $referrer->id
                    ]);
                }
            } catch (\Exception $e) {
                Log::error($e);
            }
        }

        Auth::login($user);

        return redirect('/reports')
            ->with('onboard', 'yes');
    }
}
