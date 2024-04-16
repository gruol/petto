<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{CustomerPets,
    Shipment,
    Customer,
    Clinic
};
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ClinicResource;
use App\Http\Controllers\Api\BaseController as BaseController;
Use Exception;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Arr;
use GuzzleHttp\Client;
use Str;
use Storage;
use Asset;
use Validator;
use DB;
use Hash;
use Config;
use Carbon\Carbon;
use Image;
use File;
class ClinicApiController extends BaseController
{
    public function __construct()
    {

        date_default_timezone_set("Asia/Karachi");

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clinicStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:clinics',
            'password' => 'required|string',
            'clinic_name' => 'required|string',
            'manager_name' => 'required|string',
            'contact' => 'required|string',
        ]);

        if($validator->fails())
        {
            return $this->sendError( $validator->errors()->first());

        }
        $clinicData = [ 
            "clinic_name" => $request->clinic_name,
            "password" =>  Hash::make($request->password) ,
            "manager_name" => $request->manager_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "address" => $request->address,
            "city" => $request->city,
            "country" => $request->country

        ];
        $clinic     = Clinic::create($clinicData );
        return $this->sendResponse([], 'Clinic creation request has been forwarded to Petto team for review and approval');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails())
        {
            return $this->sendError($validator->errors()->first());

        }
        $fields = $request->all();
        $clinic = Clinic::where('email',$request->email)->first(); //check Customer Exist or not

        // Check password
        if(!$clinic ||  !Hash::check($fields['password'], $clinic->password))  {
            return $this->sendError('Invalid Login Credentials');
        }

        $clinic->otp             = random_int(100000, 999999);
        $clinic->otp_created_at  = Carbon::now();
        $clinic->save();

        return $this->sendResponse(new ClinicResource($clinic), 'Clinic retrieved successfully.');
    }
    public function sendOtp(Request $request)
    {
        // try{
            // $otpVia  = $request->input('otpVia');
        $otpCode = random_int(1000, 9999);
        if (isset($request->email) && $request->email != null) {
            $clinic = Clinic::where('email',$request->email)->first();
            $clinic->otp = $otpCode;
            $clinic->otp_created_at = Carbon::now();
            $clinic->update();
        }else{
            $clinic   = Auth::guard('sanctum')->user();
            Clinic::where('id',$clinic->id)->update(['otp' => $otpCode,'otp_created_at' => Carbon::now()]);
        }

            // if($otpVia == 1)
            // {
                // $message = "Your OTP is : " . $otpCode . "." ;
              // return  smsNewApi($clinic->phone, $message);
            // }
            // elseif($otpVia == 2)
            // {
        $message = "Your OTP is : " . $otpCode . "." ;


            //     $details = [
            //         'title' => Config::get('constants._PROJECT_NAME'),
            //         'body' => $otpCode
            //     ];
            //     \Mail::to($clinic->email)->send(new \App\Mail\SupervisorSendOtpMail($details));

            // }

            // $clinic = Auth::guard('sanctum')->user();
            // if($clinic->otpVerified == 0)
            // {
            //     $data = [
            //         'otpVerification' => true,
            //     ];
            // }
            // else{

        $data = null;
            // }
    // return $this->sendResponse( $message,$data);

    // return $this->sendResponse($data "OTP has been sent", );
        return $this->sendResponse($data ,$message );

        // }catch(\Exception $e){
        //     DB::rollback();
        //     return $this->sendError("Process Failed", null);

        // }

    }
    public function verifyOtp(Request $request)
    {

        $user = Auth::guard('sanctum')->user();
        $clinic = Clinic::find($user->id);

        $tokenStartTime = Carbon::now();
        $tokenEndTime   = Carbon::parse($clinic->otp_created_at);

        // Calculate the difference in minutes
        $differenceInMinutes = $tokenStartTime->diffInMinutes($tokenEndTime);

        if($differenceInMinutes > 5){ // check implement for to  check token expire time

            return $this->sendError("OTP expired, try again", null);
        }

        if($request->input('otp') == $clinic->otp)
        {
            $clinic = Clinic::where('id', $clinic->id)->update(['is_otp_verified' => 1]);


            $message = 'Dear Customer, your account has been verified VIA OTP.';


            return $this->sendResponse(null,"OTP Verified" );
        }
        else
        {
            return $this->sendError("Process Failed/OTP Mismatch", null);

        }

        exit();

    }
    public function forgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'newPassword' => ['required'],
            'newPasswordConfirm' => ['same:newPassword'],
        ]);

        $fields = $request->all();

        if($validator->fails())
        {
            return $this->sendError($validator->errors()->first());
        }

        $clinic = Clinic::where(['email' => $fields['email'] ])->first();
        if(!$clinic) {
            return $this->sendError('No Customer found');
        }
        $clinic->tokens()->delete();


        $clinic->password = Hash::make($request->input('newPassword'));
        $clinic->update();
        $data = null;

        return $this->sendResponse($data ,'Password Reset successfully' , 704);

    }
    public function changePassword(Request $request)
    {

        $validator =  Validator::make($request->all(),[
            'currentPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'
        ],
        'newPasswordConfirm' => ['same:newPassword'],
    ]);

        if($validator->fails())
        {
            return $this->sendError($validator->errors()->first());

        }

        $newPassword = $request->input('newPassword');
        $newPasswordConfirm = $request->input('newPasswordConfirm');


        // if($newPassword !== $newPasswordConfirm)
        // {
        //     return $this->sendError('Passwords do not match');


        // }

        $user = Auth::guard('sanctum')->user();
        $clinic = Clinic::where(['email' => $user->email, 'is_deleted' => 0], )->first();

        if($clinic == null)
        {
            return $this->sendError('No Data found with this email');

        }
        $clinic->tokens()->delete();
        // else{

        Clinic::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('newPassword'))]);

        $data = null;


        return $this->sendResponse($data ,'Password Changed' , 703);

        // }

    }

    

    public function logout()
    {
        Auth::guard('customer')->user()->tokens()->delete();

        $data = null;

        return $this->sendResponse('Logged Out', $data, 702);

    }
}
