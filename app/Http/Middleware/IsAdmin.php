<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if(\Auth::user()->isAdmin())
        {
            return $next($request);
        }

        return redirect('/')->with(['alert-danger'=> 'You have not permission to enter here']);
    }
}
