<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(), 
        [
            'email'    => 'required',
            'password' => 'required'
        ]);

        if($validate->fails()) {
            return back()->withErrors($validate);
        } else {

            $attempt = Auth::attempt(['email_address' => $request->email, 'password' => $request->password], true);

            if($attempt) {

                $user = Auth::user();
                switch($user->role) {
                    case 1:
                        return redirect('/reports');
                    break;

                    case 2:
                        return redirect('/staffpanel');
                    break;

                    case 3:
                        return redirect('/reports'); 
                    break;

                    default:
                        return redirect('/reports');
                    break;
                }
                
            } else {
                return back()->with('error', 'Your credentials are invalid');
            }
        }
    }
}
