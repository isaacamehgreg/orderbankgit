<?php

namespace App\Http\Middleware;

use Closure;

class Subscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // private $allowed = [
    //     '/subscription',
    //     '/subscription/*',
    //     '/account/*',
    //     'verify-payment',
    //     '/verify-payment/*',
    //     '/logout'
    // ];

    public function handle($request, Closure $next)
    {
        // foreach($this->allowed as $allowed) {
        //     if ($allowed !== '/') {
        //         $allowed = trim($allowed, '/');
        //     }

        //     if($request->is($allowed)) {
        //         return $next($request);
        //     }
        // }

        $user = \auth()->user();
        
        if ($user) {
            if($user->role == 1) {
                if ($user->orders_count == 0 || $user->orders_count == NULL) {
                    return \session()->flash('success', 'You have no order slot left for this month. Kindly upgrade.');
                }
            }
        }

        return $next($request);
    }
}
