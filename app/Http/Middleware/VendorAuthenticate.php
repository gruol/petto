<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = 'vendor')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('vendor.login');
        }
        if (Auth::guard($guard)->user()->is_approved == 0) {
             return redirect()->route('vendor.login')->with('error',"Your Account is Pending for Admin Approval.");

        }elseif (Auth::guard($guard)->user()->is_approved == 2) {
             return redirect()->route('vendor.login')->with('error',"Your Account is Rejected by Admin.");

        }

        return $next($request);
    }
}
