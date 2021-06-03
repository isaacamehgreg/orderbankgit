<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return $_SERVER['DOCUMENT_ROOT'];
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('Africa/Lagos');

        // hook to generate users' referral code
        User::created(function($user) {
            $hash = hash('sha256', $user->id);
            $ref = substr($hash, 0, 8);
            $user->update(['referral_code' => $ref]);
        });

        error_reporting(0);
        ini_set('display_errors', 0);
    }
}
