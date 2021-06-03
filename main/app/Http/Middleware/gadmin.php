<?php

namespace App\Http\Middleware;

use Closure;

class gadmin
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
            if (!$user->is_gadmin) {
                return abort(404);
            }
        }

        return $next($request);
    }
}
