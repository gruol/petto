<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
  Shipment ,
  CustomerPets
};
use Yajra\DataTables\DataTables;
use Validator;
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
            // $action_list    .= '<a class="dropdown-item" href="'.route('admin.shipment.edit',$data->id).'"><i class="fas fa fa-pencil-ruler"></i> Shipment Edit</a>';
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

        $shipment               = Shipment::find($request->shipment_id);
        $shipment->quotation    = $request->quotation;

        $remarks = $shipment->remarks ;
        $remarks .= "<br><b>Posted by (Admin)</b>:".$user->name.", <b> Posted At </b>:".date('Y-m-d h:i ').", <b> Quotation </b>:". $request->quotation ." <br><b> Remarks:</b>".$request->remarks ;
        $shipment->remarks = $remarks;
        $shipment->update();
        return redirect()->route('admin.shipment.index');
    }
}
