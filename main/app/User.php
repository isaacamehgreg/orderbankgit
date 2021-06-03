<?php

namespace App;

use App\Store;
use App\Wallet;
use App\Business;
use App\Subscriptions;
use App\Models\BankDetails;
use App\BusinessSubscription;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'lastname','firstname','business_name','email','password','business_phone_number','address',
        'referral_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function business() {
        return Business::where('user_id', $this->id)->first();
    }

    public function businesses()
    {
        return $this->hasOne('App\Business');
    }

    public function wallets()
    {
        return $this->hasOne('App\Wallet');
    }

    public function isProfileComplete() {
        if ($this->firstname == '' || $this->lastname == '') {
            return false;
        } else {
            return true;
        }
    }

    public function isBusinessProfileComplete() {
        if($this->business()->business_name == '' || $this->business()->business_address == '' || $this->business()->business_phone_number == '' || $this->business()->business_email == '') {
            return false;
        } else {
            return true;
        }
    }

    public function wallet() {

        $business_id = '';
        if ($this->role == 1) {
            $business_id = $this->id;
        } else {
            $business_id = $this->business_id;
        }

        $check = Wallet::where('user_id', $business_id)->count();

        if ($check == 0) {
            $wallet = new Wallet();
            $wallet->user_id = $business_id;
            $wallet->save();
        }

        return Wallet::where('user_id', $business_id)->first()->balance ?? 0;
    }

    public function totalOrdersLeft() {
        return $this->orders_count;
    }

    public function totalOrdersForTheMonth() {
        dd($current_orders);
    }

    public function subscribed() {
        $subcribed = BusinessSubscription::where('user_id', $this->id)->count();
        if ($subcribed == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function subscriptionStatus() {
        $subcribed = BusinessSubscription::where('user_id', $this->id)->where('end_at', '>=', time())->count();
        if ($subcribed == 0) {
            return "Expired";
        } else {
            return "Active";
        }
    }

    public function subscription() {
        $subscription = BusinessSubscription::where('user_id', $this->id)->first();
        if ($subscription) {
            // todo: account for mixed up table rows which shifts the ID for basic plan to 3
            // remove the check after the table has been truncated
            if ($subscription->subscription_id == 1) {
                $subscription->subscription_id = 3;
            }
            return Subscriptions::find($subscription->subscription_id)->title ?? '';
        } else {
            return '';
        }
    }

    public function currentBankDetails() {
        // retrieve the last account details that was saved by the user
        return BankDetails::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function businessNameSlug() {
        return str_slug($this->business()->business_name);
    }

    public function hasStore() {
        $store = Store::where('user_id', $this->id)->count();
        if($store == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Store
     */
    public function store() {
        return Store::where('user_id', $this->id)->first();
    }
}
