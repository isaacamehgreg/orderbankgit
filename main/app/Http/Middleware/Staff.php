<?php

namespace App\Http\Middleware;

use Closure;

class Staff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \auth()->user();
        
        if ($user) {
            if ($user->is_staff) {
                return \session()->flash('success', '');
            }
        }

        return $next($request);
    }
}
