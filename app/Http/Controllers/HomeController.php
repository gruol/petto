<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
  Shipment ,Vendor,
  CustomerPets,Appointment,Doctor,Customer,Clinic

};
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

        $pageTitle = 'Dashboard';
        $registeredPets = CustomerPets::selectRaw(" count( CASE WHEN category = 'Dog' THEN 1 ELSE NULL END ) AS DogCount,
            count( CASE WHEN category = 'Cat' THEN 1 ELSE NULL END ) AS CatCount,
            count( CASE WHEN category = 'Bird' THEN 1 ELSE NULL END ) AS BirdCount,count(*) as totaRegisteredPets")->first();
        $appointments = Appointment::selectRaw("count( CASE WHEN is_confirmed = 0 THEN 1 ELSE NULL END ) AS pendingAppointments,
            count( CASE WHEN is_confirmed = 1 && status = 'PENDING'   THEN 1 ELSE NULL END ) AS pendingConsultation,
            count( CASE WHEN status = 'COMPLETED' THEN 1 ELSE NULL END ) AS completedConsultation,
            count( * ) AS totalAppointments")->first();
            $user = [];
            $user['doctorCount'] = Doctor::count();
            $user['clinicCount'] = Clinic::count();
            $user['customerCount'] = Customer::count();
      

//         SELECT
//     count( CASE WHEN query_status = 'Pending' THEN 1 ELSE NULL END ) AS queryPendingCount,
//     count( CASE WHEN query_status = 'Responded' THEN 1 ELSE NULL END ) AS queryRespondedCount,

// FROM
//     `shipments` 
        return view('admin.dashboard.dashboard',compact('registeredPets','appointments','user'))->with('pageTitle');
    }


    public function vendors(Request $request)
    {
        $pageTitle = 'Vendors';
        $approvelStatus = [0,1,2];

        if($request->ajax()){
           $data =  Vendor::query();
           return DataTables::of($data)
           ->addColumn('action',function($data){
  $action_list    = '<a class="dropdown-item btn-change-approvelStatus" href="#" data-status="'.$data->is_approved.'" data-id="'.$data->id.'"><i class="fas fa-pencil-ruler"></i> Change  Status</a>';

               return $action_list ;
           })
           ->addIndexColumn()
           // ->rawColumns(['action'])
           ->make(true);
       }

       return view('admin.vendor.index',compact('pageTitle','approvelStatus'));

   }
    public function vendorStatusUpdate(Request $request)
    {
      // dd($request->all());
        $id                     = $request->get('id');
        $vendor                 = Vendor::find($id);
        $vendor->is_approved    = $request->get('status');
        // if ($request->get('status') == 1) {
        //     $details = [
        //         'title' => Config::get('constants._PROJECT_NAME'),
        //         'name' => $vendor->manager_name
        //     ];
        //     \Mail::to($vendor->email)->send(new \App\Mail\sendVendorApprovalEmail($details));
        // }
        // $vendor->approved_at    = time();
        $vendor->save();

        return json_encode(array("status"=>true, "message"=>"Vendor Status has been updated successfully!"));
    }
}
