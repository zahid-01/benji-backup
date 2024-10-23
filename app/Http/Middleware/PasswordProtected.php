<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordProtected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //$storedPassword = $request->session()->get('access_password');

       // if ($storedPassword && env('WEB_PASSWORD') === $storedPassword) {
            return $next($request);
        //}
        //return redirect("/")->withErrors(['password' => 'Incorrect password.']);
    }
}
