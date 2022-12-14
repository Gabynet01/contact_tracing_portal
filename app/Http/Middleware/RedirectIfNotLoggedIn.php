<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\SpecialUsers;
use Illuminate\Support\Str;

class RedirectIfNotLoggedIn
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
        // Check for employee id to ensure user is logged in
        if (!Session::has('email')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
