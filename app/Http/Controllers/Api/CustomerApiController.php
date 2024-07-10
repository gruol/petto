<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{CustomerPets,
	Shipment,
	Customer,
    Country,
    ShipmentPet,
    Appointment
};
use App\Http\Resources\CustomerResource;
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
class CustomerApiController extends BaseController
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
    public function store(Request $request)
    {

    	$validator = Validator::make($request->all(), [
            'email' => 'required|unique:customers|unique:clinics|max:128',
            'password' => 'required|string',
        ]);

    	if($validator->fails())
    	{
    		return $this->sendError( $validator->errors()->first());

    	}
    	$customerData = [ 
    		"name" => $request->name,
    		"password" =>  Hash::make($request->password) ,
    		"contact_no" => $request->contact_no,
    		"email" => $request->email,
    		"dob" => $request->dob,
    		"country" => $request->country,

    	];

        $customer     = Customer::create($customerData );

        $obj                 =  new CustomerPets;
        $obj->customer_id    = $customer->id;
        $obj->name           = $request->pet_name;
        $obj->breed          = $request->pet_breed;
        $obj->age            = $request->pet_age;
        $obj->category       = $request->pet_category;
        $obj->save();

        return $this->sendResponse([], 'Customer created successfully.');

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
        $customer = Customer::with('Pets')->where('email',$request->email)->first(); //check Customer Exist or not

        // Check password
        if(!$customer ||  !Hash::check($fields['password'], $customer->password))  {
        	return $this->sendError('Invalid Login Credentials');
        }

        $customer->otp             = random_int(100000, 999999);
        $customer->otp_created_at  = Carbon::now();
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully.');
    }
    public function sendOtp(Request $request)
    {
        try{
         $otpCode = random_int(1000, 9999);
         if (isset($request->email) && $request->email != null) {
          $customer = Customer::where('email',$request->email)->first();
          if ($customer) {
            $customer->otp = $otpCode;
            $customer->otp_created_at = Carbon::now();
            $customer->update();
        }
    }else{
      $customer   = Auth::guard('sanctum')->user();
      Customer::where('id',$customer->id)->update(['otp' => $otpCode,'otp_created_at' => Carbon::now()]);
  }


  $message = "OTP has been sent to your registered email address.";


  $details = [
    'title' => Config::get('constants._PROJECT_NAME'),
    'otpCode' => $otpCode,
    'name' => $customer->name
];

          // return view('emails.sendOtp',compact('details'));

\Mail::to($customer->email)->send(new \App\Mail\sendOTPEmail($details));



$data = null;

return $this->sendResponse($data ,$message );

}catch(\Exception $e){
    DB::rollback();
    return $this->sendError("Process Failed", null);

}

}
public function verifyOtp(Request $request)
{

 $user = Auth::guard('sanctum')->user();
 $customer = Customer::find($user->id);

 $tokenStartTime = Carbon::now();
 $tokenEndTime   = Carbon::parse($customer->otp_created_at);

        // Calculate the difference in minutes
 $differenceInMinutes = $tokenStartTime->diffInMinutes($tokenEndTime);

        if($differenceInMinutes > 20){ // check implement for to  check token expire time

        	return $this->sendError("OTP expired, try again", null);
        }

        if($request->input('otp') == $customer->otp)
        {
        	Customer::where('id', $customer->id)->update(['is_otp_verified' => 1]);

         $message = "OTP has been sent to your registered email address.";

         $details = [
            'title' => Config::get('constants._PROJECT_NAME'),
            'name' => $customer->name
        ];

          // return view('emails.sendWellCome',compact('details'));

        \Mail::to($customer->email)->send(new \App\Mail\sendWellComeEmail($details));

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

$customer = Customer::where(['email' => $fields['email'] ])->first();
if(!$customer) {
  return $this->sendError('No Customer found');
}
$customer->tokens()->delete();


$customer->password = Hash::make($request->input('newPassword'));
$customer->update();
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
 $customer = Customer::where(['email' => $user->email, 'is_deleted' => 0], )->first();

 if($customer == null)
 {
  return $this->sendError('No Data found with this email');

}
$customer->tokens()->delete();
        // else{

Customer::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('newPassword'))]);

$data = null;


return $this->sendResponse($data ,'Password Changed' , 703);

        // }

}

public function addPet(Request $request)
{
 $validator =  Validator::make($request->all(),[
  'name'      => ['required'],
  'breed'     => ['required'],
  'age'       => ['required'],
  'category'  => ['required'],
      // 'picture'  => ['required']

]);

 if($validator->fails())
 {
  return $this->sendError($validator->errors()->first());

}
$user                = Auth::guard('sanctum')->user();
$obj                 =  new CustomerPets;
$obj->customer_id    = $user->id;
$obj->name           = $request->name;
$obj->breed          = $request->breed;
$obj->age            = $request->age;
$obj->category       = $request->category;

if($request['picture'] != null)
{

    $image = $request['picture']; 
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1];
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $picture = 'picture_'.$user->id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/pet/".$user->id.'/'.$picture, base64_decode($image));
    $picture = env('APP_URL')."public/storage/uploads/pet/".$user->id.'/'.$picture;
}

else{
    $picture = 'null';
}
$obj->picture        = $picture;

$obj->save();
$data = null;


return $this->sendResponse($data,'Pet Info saved' , 703);
}

public function updatePet(Request $request)
{

 $validator =  Validator::make($request->all(),[
  'name'      => ['required'],
  'breed'     => ['required'],
  'age'       => ['required'],
  'category'  => ['required'],
  'picture'   => ['required']

]);

 if($validator->fails())
 {
  return $this->sendError($validator->errors()->first());

}
$user                = Auth::guard('sanctum')->user();
$obj                 = CustomerPets::find( $request->pet_id);

if (empty($obj)  ) {
  return $this->sendResponse(null,"No Pet Found" );  
}
$obj->customer_id    = $user->id;
$obj->name           = $request->name;
$obj->breed          = $request->breed;
$obj->age            = $request->age;
$obj->category       = $request->category;

if($request['picture'] != null)
{

    $image = $request['picture']; 
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1];
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $picture = 'picture_'.$user->id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/pet/".$user->id.'/'.$picture, base64_decode($image));
    $picture = env('APP_URL')."public/storage/uploads/pet/".$user->id.'/'.$picture;
}

else{
    $picture = 'null';
}
$obj->picture        = $picture;
$attechments = [];
if (count($request->additional_documents) > 0) {
    foreach($request->additional_documents as $key => $documents){
        $image = $documents; 
        $pos  = strpos($image, ';');
        $type = explode(':', substr($image, 0, $pos))[1];
        $type = explode('/',$type);
        $extension = $type[1];
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $picture = 'picture_'.$user->id.'_time_'.time().'.'.$extension;
        Storage::put("public/uploads/pet/".$user->id.'/'.$picture, base64_decode($image));
        $picture = env('APP_URL')."public/storage/uploads/pet/".$user->id.'/'.$picture;
        $attechments[$request->additional_documents_name[$key]] = $picture ;
    }
    $obj->attachments = json_encode($attechments);
}
$obj->save();
$data = null;


return $this->sendResponse($data,'Pet Info Update' , 703);
}
public function deletePet(Request $request)
{
 $validator =  Validator::make($request->all(),[
  'id'      => ['required'],
]);

 if($validator->fails())
 {
  return $this->sendError($validator->errors()->first());

}
$user                = Auth::guard('sanctum')->user();
$obj                 = CustomerPets::where('id', $request->id)->first();
if(empty($obj)){
    return $this->sendResponse(null,'Pet Not Found' , 703);
}else{
    $obj->delete();
}

return $this->sendResponse(null,'Pet Info Deleted' , 703);
}
public function shipmentBooking(Request $request)
{
 $validator =  Validator::make($request->all(),[
  'origin'      => ['required'],
  'destination' => ['required'],
  'pet'         => ['required'],
  'have_cage'   => ['required']

]);

 if($validator->fails())
 {
  return $this->sendError($validator->errors()->first());

}
$user                 = Auth::guard('sanctum')->user();
$obj                  = new Shipment;
$obj->time_id 		= time(); 
$obj->customer_id 	= $user->id; 
$obj->query_status    = "Pending"; 
$obj->shipment_status = "Pending"; 
$obj->payment_status  = "Pending"; 
$obj->category 		= $request->category; 
$obj->origin 		    = $request->origin; 
$obj->destination 	= $request->destination; 
// $obj->pet_ids 		= $request->pet; 
$obj->gross_weight 	= $request->gross_weight; 
$obj->pet_dimensions  = $request->pet_dimensions; 
$obj->have_cage 	    = $request->have_cage; 
$obj->cage_dimensions = $request->cage_dimensions; 
$obj->want_booking 	= $request->want_booking; 
$obj->save();

foreach ($request->pet as $key => $pet_id) {
    if (isset($pet_id ) && $pet_id > 0 ) {
        $obj2 =   New ShipmentPet;
        $obj2->pet_id = $pet_id;
        $obj2->shipment_id = $obj->id;
        $obj2->save();
    }
}
$details = [
    'title' => Config::get('constants._PROJECT_NAME'),
    'name' => $user->name
];
\Mail::to($user->email)->send(new \App\Mail\sendShipmentQueryEmail($details));

$data = null;
return $this->sendResponse($data,'shipment Info saved', 703);
}


public function unaccompaniedBooking(Request $request)
{


    $validator =  Validator::make($request->all(),[
      "shipper_name" => ["required"],
      "shipper_address" => ["required"],
      "shipper_cnic" => ["required"],
      "shipper_contact" => ["required"],
      "shipper_email" => ["required"],
      "consignee_name" => ["required"],
      "consignee_address" => ["required"],
      "consignee_contact" => ["required"],
      "consignee_email" => ["required"],
      "pet_photo1" => ["required"],
      "pet_photo2" => ["required"],
      "pet_passport" => ["required"],
      "microchip" => ["required"],
      "microchip_no" => ["required"],
      "health_certificate" => ["required"],
      "import_permit" => ["required"],
      "titer_report" => ["required"],
      "passport_copy" => ["required"],
      "cnic_copy" => ["required"],
      "ticket_copy" => ["required"],

  ]);

    if($validator->fails())
    {
      return $this->sendError($validator->errors()->first());

  }
  $user               	    = Auth::guard('sanctum')->user();
  $obj                	    = Shipment::find($request->application_id);
  $obj->shipper_name 		= $request->shipper_name;
  $obj->shipper_address 	= $request->shipper_address;
  $obj->shipper_cnic 		= $request->shipper_cnic;
  $obj->shipper_contact 	= $request->shipper_contact;
  $obj->shipper_email 	    = $request->shipper_email;
  $obj->consignee_name 	    = $request->consignee_name;
  $obj->consignee_address   = $request->consignee_address;
  $obj->consignee_contact   = $request->consignee_contact;
  $obj->consignee_email 	= $request->consignee_email;

  if($request['pet_photo1'] != null)
  {

    $image = $request['pet_photo1'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1];
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $pet_photo1 = 'pet_photo1_'.$request->shipment_id.'_time_'.time().'.'. $extension;

    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$pet_photo1, base64_decode($image));
    $pet_photo1 = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$pet_photo1;

}

else{
    $pet_photo1 = 'null';
}
$obj->pet_photo1 		= $pet_photo1;

if($request['pet_photo2'] != null)
{

    $image = $request['pet_photo2']; 
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $pet_photo2 = 'pet_photo2_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$pet_photo2, base64_decode($image));
    $pet_photo2 = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$pet_photo2;

}

else{
    $pet_photo2 = 'null';
}

$obj->pet_photo2 		= $pet_photo2;

if($request['pet_passport'] != null)
{

    $image = $request['pet_passport'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $pet_passport = 'pet_passport_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$pet_passport, base64_decode($image));
    $pet_passport = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$pet_passport;

}

else{
    $pet_passport = 'null';
}

$obj->pet_passport 		=  $pet_passport;

$obj->microchip 		= $request->microchip;
$obj->microchip_no 		= $request->microchip_no;
if($request['health_certificate'] != null)
{

    $image = $request['health_certificate'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $health_certificate = 'health_certificate_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$health_certificate, base64_decode($image));
    $health_certificate = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$health_certificate;

}

else{
    $health_certificate = 'null';
}

$obj->health_certificate= $health_certificate;

if($request['import_permit'] != null)
{

    $image = $request['import_permit'];
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1];  
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $import_permit = 'import_permit_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$import_permit, base64_decode($image));
    $import_permit = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$import_permit;

}

else{
    $import_permit = 'null';
}

$obj->import_permit 	= $import_permit;

if($request['titer_report'] != null)
{

    $image = $request['titer_report'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $titer_report = 'titer_report_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$titer_report, base64_decode($image));
    $titer_report = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$titer_report;

}

else{
    $titer_report = 'null';
}

$obj->titer_report 		= $titer_report;

if($request['passport_copy'] != null)
{

    $image = $request['passport_copy'];
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1];   
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $passport_copy = 'passport_copy_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$passport_copy, base64_decode($image));
    $passport_copy = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$passport_copy;

}

else{
    $passport_copy = 'null';
}

$obj->passport_copy 	= $passport_copy;

if($request['cnic_copy'] != null)
{

    $image = $request['cnic_copy'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $cnic_copy = 'cnic_copy_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$cnic_copy, base64_decode($image));
    $cnic_copy = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$cnic_copy;

}

else{
    $cnic_copy = 'null';
}

$obj->cnic_copy 		= $cnic_copy;

if($request['ticket_copy'] != null)
{

    $image = $request['ticket_copy'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $ticket_copy = 'ticket_copy_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$ticket_copy, base64_decode($image));
    $ticket_copy = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$ticket_copy;

}

else{
    $ticket_copy = 'null';
}
$obj->ticket_copy       = $ticket_copy;

if($request['visa_copy'] != null)
{

    $image = $request['visa_copy'];  
    $pos  = strpos($image, ';');
    $type = explode(':', substr($image, 0, $pos))[1];
    $type = explode('/',$type);
    $extension = $type[1]; 
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $visa_copy = 'visa_copy_'.$request->application_id.'_time_'.time().'.'.$extension;
    Storage::put("public/uploads/shipment/".$request->application_id.'/'.$visa_copy, base64_decode($image));
    $visa_copy = env('APP_URL')."public/storage/uploads/shipment/".$request->application_id.'/'.$visa_copy;

}

else{
    $visa_copy = 'null';
}

$obj->visa_copy 		= $visa_copy;
$obj->save();
$data = null;
return $this->sendResponse( $data,'shipment Info saved', 703);
}


public function sync($value='')
{   
    $data = [];
    $data['customer']   = Customer::where('id',Auth::user()->id)->get()->toArray();   
    // $data['countries']  = Country::where('is_active',1)->get()->toArray();   
    $data['shipments']  = Shipment::with('ShipmentPet.Pets','ShipmentBy')->where('customer_id',Auth::user()->id)->get()->toArray();
    $data['pets']       = CustomerPets::where('customer_id',Auth::user()->id)->get()->toArray();

    return $this->sendResponse( $data,'Data Found', 702);

}
public function postRemarks(Request $request)
{

  $obj                      = Shipment::find($request->shipment_id);
  $user                     = Auth::guard('sanctum')->user();

  $shipment                 = Shipment::find($request->shipment_id);
  
  $remarks = $shipment->remarks ;
  $remarks .= "<br><b>Posted by (Customer)</b>:".$user->name.", <b> Posted At </b>:".date('Y-m-d h:i ')." <br><b> Remarks:</b>".$request->remarks ;
  $shipment->remarks = $remarks;

  $shipment->update();
  $data =null;
  return $this->sendResponse('Ramarks Saved', $data, 702);


}
public function customerData()
{
    $data   = Customer::where('id',Auth::user()->id)->get()->toArray();  
    return $this->sendResponse( $data,'Customer Data', 702);

}
public function customerShipments()
{
    $data  = Shipment::with('ShipmentPet.Pets','ShipmentBy')->where('customer_id',Auth::user()->id)->get()->toArray();

    return $this->sendResponse( $data,'Customer Shipments Data', 702);

}
public function customerPets()
{
    $data = CustomerPets::where('customer_id',Auth::user()->id)->get()->toArray();

    return $this->sendResponse( $data,'Customer Pets Data', 702);

}
public function countries()
{
    $data       = Country::where('is_active',1)->get()->toArray();

    return $this->sendResponse( $data,'Countries Data', 702);

}
public function customerPet($id)
{
    $data = CustomerPets::where(['id' => $id ,'customer_id' => Auth::user()->id])->get()->toArray();

    return $this->sendResponse( $data,'Customer Pet', 702);

}
public function customerAppointments(Request $request)
{
    $data = null;
    $user = Auth::user();
    $data = Appointment::with(['customer','doctor','doctor.clinic','pet'])->withCount('review','review');
    $data->where('customer_id',$user->id );
    $data = $data->get()->toArray();
    return $this->sendResponse( $data,"Customer's Appointments List" , 702);

}
public function logout()
{
    Auth::guard('sanctum')->user()->tokens()->delete();

    $data = null;

    return $this->sendResponse('Logged Out', $data, 702);

}



}
