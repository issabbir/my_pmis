<?php

namespace App\Http\Middleware;

use Closure;

class DashboardApiMiddleware
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

        $user_id = auth()->id;

        $request->attributes->add(['user_id' => $user_id]);

        return $next($request);
    }
}
