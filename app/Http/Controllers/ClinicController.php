<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
  Clinic ,
  CustomerPets,Appointment,Doctor
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
        $clinicStatus = [ 1 =>"Approved", 2 => "Rejected"];
        return view('admin.clinics.index',compact('pageTitle','clinicStatus'));
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
            $action_list    .= '<a class="dropdown-item btn-change-clinicStatus" href="#" data-status="'.$data->is_approved.'" data-id="'.$data->id.'"><i class="fas fa-pencil-ruler"></i> Change Status</a>';

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
        ->addColumn('is_approved', function ($data) {
            if ($data->is_approved == 1 ) {
                return "Approved";
            }elseif ($data->is_approved == 2) {
                return "Rejected";
            }else{
                return "Pending";
            }
        })
        ->rawColumns(['actions'])
        ->make(TRUE);

    }
    public function clinicView($id)
    {
        $pageTitle              = "Clinic View";
        $clinic                = Clinic::with(['doctors','doctors.AppointmentTime','doctors.AppointmentDay','doctors.AppointmentDate'])
            // ->withCount( 'review','review')
        ->find($id);
        // dd( $clinic   );
            //        $doctors = Doctor::with('AppointmentTime','AppointmentDay','AppointmentDate','clinic')
            // ->withCount( 'appointment','appointment');
        return view('admin.clinics.view',compact('pageTitle','clinic'));

    }
    public function clinicEdit($id)
    {
        $pageTitle              = "Clinic Edit";
        $clinic               = Clinic::with(['ClinicBy','ClinicPet.Pets'])->find($id);
        
        return view('admin.clinics.edit',compact('pageTitle','clinic'));

    }
  
    public function clinicStatusUpdate(Request $request)
    {
        $id                     = $request->get('clinic_id');
        $status                 = $request->get('status');
        $clinic                 = Clinic::find($id);
        $clinic->is_approved    = $request->get('status');
        $clinic->approved_at    = time();
        $clinic->save();

        return json_encode(array("status"=>true, "message"=>"Clinic  Status has been updated successfully!"));
    }
    public function clinicPaymentStatusUpdate(Request $request)
    {
        $id                     = $request->get('clinic_id');
        $status                 = $request->get('status');
        $clinic                = Clinic::find($id);
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
    public function appointments(Request $request)
    {
        $pageTitle           = "Appointments";
        $clinicStatus = [ 1 =>"Approved", 2 => "Rejected"];
        return view('admin.appointments.index',compact('pageTitle','clinicStatus'));
    }
    public function appointmentsData(Request $request){

        $rData = Appointment::with(['customer','doctor' ,'doctor.clinic','pet']);

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


            $action_list    .= '<a class="dropdown-item" href="'.route('admin.appointment.view',$data->id).'"><i class="fas fa fa-eye"></i> View</a>';
            // $action_list    .= '<a class="dropdown-item" href="'.route('admin.clinic.edit',$data->id).'"><i class="fas fa fa-pencil-ruler"></i> Clinic Edit</a>';
            // }

            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->addColumn('is_approved', function ($data) {
            if ($data->is_approved == 1 ) {
                return "Approved";
            }elseif ($data->is_approved == 2) {
                return "Rejected";
            }else{
                return "Pending";
            }
        })
        ->rawColumns(['actions'])
        ->make(TRUE);

    }
    public function appointmentView($id)
    {
        $pageTitle              = "Appointment View";
        $appointment            = Appointment::with(['customer','doctor','doctor.clinic','pet'])->find($id);
        // dd( $appointment);
        return view('admin.appointments.view',compact('pageTitle','appointment'));

    }

    public function doctorStatusUpdate(Request $request)
    {
        $id                     = $request->get('doctor_id');
        $status                 = $request->get('status');
        $doctor                 = Doctor::find($id);
        $doctor->is_approved    = $request->get('status');
        $doctor->approved_at    = time();
        $doctor->save();

        return json_encode(array("status"=>true, "message"=>"Doctor  Status has been updated successfully!"));
    }
    // Doctor
      public function doctors(Request $request)
    {
        $pageTitle           = "Doctors";
        $doctorStatus = [ 1 =>"Approved", 2 => "Rejected"];
        return view('admin.doctors.index',compact('pageTitle','doctorStatus'));
    }
    public function doctorsData(Request $request){
        $rData                 = Doctor::with(['clinic']);

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
            $action_list    .= '<a class="dropdown-item btn-change-doctorStatus" href="#" data-status="'.$data->is_approved.'" data-id="'.$data->id.'"><i class="fas fa-pencil-ruler"></i> Change Status</a>';

            // $action_list    .= '<a class="dropdown-item btn-change-doctorStatus" href="#" data-status="'.$data->clinic_status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Clinic Status</a>';
            // $action_list    .= '<a class="dropdown-item btn-change-paymentStatus" href="#" data-status="'.$data->payment_status.'" data-id="'.$data->id.'"><i class="fas fa-dollar-sign"></i> Change Payment Status</a>';
            // }
            // if(auth()->user()->can('product-view')){

            $action_list    .= '<a class="dropdown-item" href="'.route('admin.doctor.view',$data->id).'"><i class="fas fa fa-eye"></i>  View</a>';
            // $action_list    .= '<a class="dropdown-item" href="'.route('admin.clinic.edit',$data->id).'"><i class="fas fa fa-pencil-ruler"></i> Clinic Edit</a>';
            // }

            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->addColumn('is_approved', function ($data) {
            if ($data->is_approved == 1 ) {
                return "Approved";
            }elseif ($data->is_approved == 2) {
                return "Rejected";
            }else{
                return "Pending";
            }
        })
        ->rawColumns(['actions'])
        ->make(TRUE);

    }
    public function doctorView($id)
    {
        $pageTitle              = "Doctor View";
        $doctor                 = Doctor::with(['clinic','AppointmentTime','AppointmentDay','AppointmentDate'])
            // ->withCount( 'review','review')
        ->find($id);
        // dd( $clinic   );
            //        $doctors = Doctor::with('AppointmentTime','AppointmentDay','AppointmentDate','clinic')
            // ->withCount( 'appointment','appointment');
        return view('admin.doctors.view',compact('pageTitle','doctor'));

    }
}
