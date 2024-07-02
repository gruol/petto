<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class OTPVerification
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
       $agent = Auth::guard('sanctum')->user();
     
        if($agent->is_otp_verified == 0)//if OTP not verified
        {

            $data = [
                'otpVerification' => true,
            ];

            $response = [
                'success' => false,
                'message' => "Your Profile is pending for OTP verification.",
                'data'    => $data,
                'status_code' => 801,
                'code'    => 200,
            ];

            return response()->json($response, 200);


        }
        return $next($request);
    }
}
