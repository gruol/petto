<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
  Shipment ,
  CustomerPets,
  Customer
};
use Config;

use Yajra\DataTables\DataTables;
use Validator;
use Storage;
use Illuminate\Support\Facades\Auth;
class ShipmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageTitle          = "Shipments";
        $shipmentQueryStatus = ["Pending", "Responded", "Confirmed"];
        $shipmentStatus = ["Pending", "On Hold", "In Transit","Delivered"];
        $paymentStatus = ["Pending", "Paid"];
        return view('admin.shipments.index',compact('pageTitle','shipmentQueryStatus','shipmentStatus','paymentStatus'));
    }
    public function ajaxtData(Request $request){

        $rData = Shipment::with('ShipmentBy');
        $rData = $rData->orderBy('id', 'DESC');

        if($request->date_from != ""){
            $rData              = $rData->where('time_id', '>=', strtotime($request->date_from));
        }
        if($request->date_to != ""){
            $rData              = $rData->where('time_id', '<=', strtotime($request->date_to));
        }
        return DataTables::of($rData->get())
        ->addIndexColumn()

        ->editColumn('date', function ($data) {
            if ($data->time_id != "")
                return date('m-d-Y h:i:s', $data->time_id);
            else
                return '-';
        })
        ->editColumn('customer_name', function ($data) {
            if ( isset($data->ShipmentBy) && $data->ShipmentBy->name != "")
                return $data->ShipmentBy->name;
            else
                return '-';
        })
        ->addColumn('actions', function ($data) {

            $action_list    = '<div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt"></i>
            </a>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';


            // if(auth()->user()->can('shipments-change-status')){
            $action_list    .= '<a class="dropdown-item btn-change-shipmentQueryStatus" href="#" data-status="'.$data->query_status.'" data-id="'.$data->id.'"><i class="fas fa-pencil-ruler"></i> Change Query Status</a>';

            $action_list    .= '<a class="dropdown-item btn-change-shipmentStatus" href="#" data-status="'.$data->shipment_status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Shipment Status</a>';
            $action_list    .= '<a class="dropdown-item btn-change-paymentStatus" href="#" data-status="'.$data->payment_status.'" data-id="'.$data->id.'"><i class="fas fa-dollar-sign"></i> Change Payment Status</a>';
            // }
            // if(auth()->user()->can('product-view')){

            $action_list    .= '<a class="dropdown-item" href="'.route('admin.shipment.view',$data->id).'"><i class="fas fa fa-eye"></i> Shipment View</a>';
            $action_list    .= '<a class="dropdown-item" href="'.route('admin.shipment.edit',$data->id).'"><i class="fas fa fa-pencil-ruler"></i> Shipment Edit</a>';
            // }

            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->rawColumns(['actions'])
        ->make(TRUE);

    }
    public function shipmentView($id)
    {
        $pageTitle              = "Shipment View";
        $shipment               = Shipment::with(['ShipmentBy','ShipmentPet.Pets'])->find($id);
        
        return view('admin.shipments.view',compact('pageTitle','shipment'));

    }
    public function shipmentEdit($id)
    {
        $pageTitle              = "Shipment Edit";
        $shipment               = Shipment::with(['ShipmentBy','ShipmentPet.Pets'])->find($id);
        
        return view('admin.shipments.edit',compact('pageTitle','shipment'));

    }
    public function shipmentUpdate(Request $request)
    {
        // dump($request->all());
     $obj =  Shipment::find($request->shipment_id);

     if($request['pet_photo1'] != null)
     {

        $image = $request['pet_photo1'];  
        // If the file exists, delete it
        $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_photo1;
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_photo1);
        }
        $image = str_replace(' ', '+', $image);
        $pet_photo1 = 'pet_photo1_'.$request->shipment_id.'_time_'.time().'.'.$request->pet_photo1->extension();
        Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$pet_photo1,file_get_contents($image));
        $obj->pet_photo1  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$pet_photo1;

    }

    if($request['pet_photo2'] != null)
    {

     $image = $request['pet_photo2'];  
        // If the file exists, delete it
     $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_photo2;
     if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_photo2);
    }
    $image = str_replace(' ', '+', $image);
    $pet_photo2 = 'pet_photo2_'.$request->shipment_id.'_time_'.time().'.'.$request->pet_photo2->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$pet_photo2,file_get_contents($image));
    $obj->pet_photo2  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$pet_photo2;

}
if($request['pet_passport'] != null)
{


    $image = $request['pet_passport'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_passport;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->pet_passport);
    }
    $image = str_replace(' ', '+', $image);
    $pet_passport = 'pet_passport_'.$request->shipment_id.'_time_'.time().'.'.$request->pet_passport->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$pet_passport,file_get_contents($image));
    $obj->pet_passport  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$pet_passport;



}

$obj->microchip         = $request->microchip;
$obj->microchip_no      = $request->microchip_no;
if($request['health_certificate'] != null)
{

    $image = $request['health_certificate'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->health_certificate;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->health_certificate);
    }
    $image = str_replace(' ', '+', $image);
    $health_certificate = 'health_certificate_'.$request->shipment_id.'_time_'.time().'.'.$request->health_certificate->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$health_certificate,file_get_contents($image));
    $obj->health_certificate  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$health_certificate;


}

if($request['import_permit'] != null)
{

    $image = $request['import_permit'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->import_permit;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->import_permit);
    }
    $image = str_replace(' ', '+', $image);
    $import_permit = 'import_permit_'.$request->shipment_id.'_time_'.time().'.'.$request->import_permit->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$import_permit,file_get_contents($image));
    $obj->import_permit  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$import_permit;

}

if($request['titer_report'] != null)
{
    $image = $request['titer_report'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->titer_report;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->titer_report);
    }
    $image = str_replace(' ', '+', $image);
    $titer_report = 'titer_report_'.$request->shipment_id.'_time_'.time().'.'.$request->titer_report->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$titer_report,file_get_contents($image));
    $obj->titer_report  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$titer_report;

}

if($request['passport_copy'] != null)
{
    $image = $request['passport_copy'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->passport_copy;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->passport_copy);
    }
    $image = str_replace(' ', '+', $image);
    $passport_copy = 'passport_copy_'.$request->shipment_id.'_time_'.time().'.'.$request->passport_copy->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$passport_copy,file_get_contents($image));
    $obj->passport_copy  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$passport_copy;


}

if($request['cnic_copy'] != null)
{

    $image = $request['cnic_copy'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->cnic_copy;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->cnic_copy);
    }
    $image = str_replace(' ', '+', $image);
    $cnic_copy = 'cnic_copy_'.$request->shipment_id.'_time_'.time().'.'.$request->cnic_copy->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$cnic_copy,file_get_contents($image));
    $obj->cnic_copy  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$cnic_copy;

}

if($request['ticket_copy'] != null)
{
    $image = $request['ticket_copy'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->ticket_copy;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->ticket_copy);
    }
    $image = str_replace(' ', '+', $image);
    $ticket_copy = 'ticket_copy_'.$request->shipment_id.'_time_'.time().'.'.$request->ticket_copy->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$ticket_copy,file_get_contents($image));
    $obj->ticket_copy  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$ticket_copy;

}

if($request['visa_copy'] != null)
{
    $image = $request['visa_copy'];  
        // If the file exists, delete it
    $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$obj->visa_copy;
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$obj->visa_copy);
    }
    $image = str_replace(' ', '+', $image);
    $visa_copy = 'visa_copy_'.$request->shipment_id.'_time_'.time().'.'.$request->visa_copy->extension();
    Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$visa_copy,file_get_contents($image));
    $obj->visa_copy  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$visa_copy;

}
$obj->update();
return redirect()->back();


}
public function shipmentQueryStatusUpdate(Request $request)
{
    $id                     = $request->get('shipment_id');
    $status                 = $request->get('status');
    $shipment               = Shipment::find($id);
    $shipment->query_status = $status;
    $shipment->save();

    return json_encode(array("status"=>true, "message"=>"Shipment Query Status has been updated successfully!"));
}
public function shipmentStatusUpdate(Request $request)
{
    $id                     = $request->get('shipment_id');
    $status                 = $request->get('status');
    $shipment               = Shipment::find($id);
    $shipment->shipment_status = $status;
    $shipment->save();
   
    return json_encode(array("status"=>true, "message"=>"Shipment  Status has been updated successfully!"));
}
public function shipmentPaymentStatusUpdate(Request $request)
{
    $id                     = $request->get('shipment_id');
    $status                 = $request->get('status');
    $shipment               = Shipment::find($id);
    $shipment->payment_status = $status;
    $shipment->save();

    return json_encode(array("status"=>true, "message"=>"Payment Status has been updated successfully!"));
}

public function addShipmentRemarks(Request $request)
{
    $user = Auth::getUser();

    $quotation_file = '';
    $shipment               = Shipment::find($request->shipment_id);
    $shipment->quotation    = $request->quotation;


    if($request['quotation_file'] != null)
    {

        $image = $request['quotation_file'];  

        $filePath = "public/uploads/shipment/".$request->shipment_id.'/'.$request->quotation_file;
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/shipment/".$request->shipment_id.'/'.$request->quotation_file);
        }
        $image = str_replace(' ', '+', $image);
        $quotation_file = 'quotation_file_'.$request->shipment_id.'_time_'.time().'.'.$request->quotation_file->extension();
        Storage::put("public/uploads/shipment/".$request->shipment_id.'/'.$quotation_file,file_get_contents($image));
        $shipment->quotation_file  = env('APP_URL')."public/storage/uploads/shipment/".$request->shipment_id.'/'.$quotation_file;
       // dump($shipment->quotation_file );
       }
    $shipment->flight_service_name   = $request->flight_service_name;
    $shipment->ticket_no             = $request->ticket_no;
    $shipment->date_time             = $request->date_time;
    $shipment->tracking_no           = $request->tracking_no;
    $customer =  Customer::find($shipment->customer_id);
   if (isset($request->ticket_no) && $request->ticket_no != '') {

        $details = [
            'title' => Config::get('constants._PROJECT_NAME'),
            'name' => $customer->name,
            'ticket_no' => $request->ticket_no,
            'date_time' => $request->date_time,
            'tracking_no' => $request->tracking_no,
            'flight_service_name' => $request->flight_service_name,
        ];
          // return view('emails.sendShipmentConfirmed',compact('details'));

        // \Mail::to($customer->email)->send(new \App\Mail\sendShipmentConfirmedEmail($details));
    }
    $remarks = $shipment->remarks ;
    $remarks .= "<br><b>Posted by (Admin)</b>:".$user->name.", <b> Posted At </b>:".date('Y-m-d h:i ').", <b> Quotation </b>:". $request->quotation ." <br><b> Remarks:</b>".$request->remarks ;
    $shipment->remarks = $remarks;

    $shipment->update();
    return redirect()->route('admin.shipment.index');
}
}
