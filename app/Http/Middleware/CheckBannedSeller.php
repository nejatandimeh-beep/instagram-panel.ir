<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBannedSeller
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
        if(Auth::guard('seller')->check() && (Auth::guard('seller')->user()->status == 0)){
            Auth::guard('seller')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('sellerLog')->with('error', 'حساب کاربری شما مسدود شده است');

        }
        return $next($request);
    }
}
