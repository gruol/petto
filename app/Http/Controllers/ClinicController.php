<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
  Clinic ,
  CustomerPets
};
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class ClinicController extends Controller
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
        $pageTitle           = "Clinics";
        $clinicQueryStatus = ["Pending", "Responded", "Confirmed"];
        $clinicStatus = ["Pending", "On Hold", "In Transit","Delivered"];
        $paymentStatus = ["Pending", "Paid"];
        return view('admin.clinics.index',compact('pageTitle','clinicQueryStatus','clinicStatus','paymentStatus'));
    }
    public function ajaxtData(Request $request){

        $rData = Clinic::all();
        // $rData = $rData->orderBy('id', 'DESC');

        // if($request->date_from != ""){
        //     $rData              = $rData->where('time_id', '>=', strtotime($request->date_from));
        // }
        // if($request->date_to != ""){
        //     $rData              = $rData->where('time_id', '<=', strtotime($request->date_to));
        // }
        return DataTables::of($rData)
        ->addIndexColumn()

        ->editColumn('date', function ($data) {
            if ($data->time_id != "")
                return date('m-d-Y h:i:s', $data->time_id);
            else
                return '-';
        })
        // ->editColumn('customer_name', function ($data) {
        //     if ( isset($data->ClinicBy) && $data->ClinicBy->name != "")
        //         return $data->ClinicBy->name;
        //     else
        //         return '-';
        // })
        ->addColumn('actions', function ($data) {

            $action_list    = '<div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt"></i>
            </a>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';


            // if(auth()->user()->can('clinics-change-status')){
            // $action_list    .= '<a class="dropdown-item btn-change-clinicQueryStatus" href="#" data-status="'.$data->query_status.'" data-id="'.$data->id.'"><i class="fas fa-pencil-ruler"></i> Change Query Status</a>';

            // $action_list    .= '<a class="dropdown-item btn-change-clinicStatus" href="#" data-status="'.$data->clinic_status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Clinic Status</a>';
            // $action_list    .= '<a class="dropdown-item btn-change-paymentStatus" href="#" data-status="'.$data->payment_status.'" data-id="'.$data->id.'"><i class="fas fa-dollar-sign"></i> Change Payment Status</a>';
            // }
            // if(auth()->user()->can('product-view')){

            $action_list    .= '<a class="dropdown-item" href="'.route('admin.clinic.view',$data->id).'"><i class="fas fa fa-eye"></i> Clinic View</a>';
            // $action_list    .= '<a class="dropdown-item" href="'.route('admin.clinic.edit',$data->id).'"><i class="fas fa fa-pencil-ruler"></i> Clinic Edit</a>';
            // }

            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->rawColumns(['actions'])
        ->make(TRUE);

    }
    public function clinicView($id)
    {
        $pageTitle              = "Clinic View";
        $clinic               = Clinic::find($id);
        
        return view('admin.clinics.view',compact('pageTitle','clinic'));

    }
    public function clinicEdit($id)
    {
        $pageTitle              = "Clinic Edit";
        $clinic               = Clinic::with(['ClinicBy','ClinicPet.Pets'])->find($id);
        
        return view('admin.clinics.edit',compact('pageTitle','clinic'));

    }
    public function clinicQueryStatusUpdate(Request $request)
    {
        $id                     = $request->get('clinic_id');
        $status                 = $request->get('status');
        $clinic               = Clinic::find($id);
        $clinic->query_status = $status;
        $clinic->save();

        return json_encode(array("status"=>true, "message"=>"Clinic Query Status has been updated successfully!"));
    }
    public function clinicStatusUpdate(Request $request)
    {
        $id                     = $request->get('clinic_id');
        $status                 = $request->get('status');
        $clinic               = Clinic::find($id);
        $clinic->clinic_status = $status;
        $clinic->save();

        return json_encode(array("status"=>true, "message"=>"Clinic  Status has been updated successfully!"));
    }
    public function clinicPaymentStatusUpdate(Request $request)
    {
        $id                     = $request->get('clinic_id');
        $status                 = $request->get('status');
        $clinic               = Clinic::find($id);
        $clinic->payment_status = $status;
        $clinic->save();

        return json_encode(array("status"=>true, "message"=>"Payment Status has been updated successfully!"));
    }

    public function addClinicRemarks(Request $request)
    {
        $user = Auth::getUser();

        $clinic               = Clinic::find($request->clinic_id);
        $clinic->quotation    = $request->quotation;

        $remarks = $clinic->remarks ;
        $remarks .= "<br><b>Posted by (Admin)</b>:".$user->name.", <b> Posted At </b>:".date('Y-m-d h:i ').", <b> Quotation </b>:". $request->quotation ." <br><b> Remarks:</b>".$request->remarks ;
        $clinic->remarks = $remarks;
        $clinic->update();
        return redirect()->route('admin.clinic.index');
    }
}
