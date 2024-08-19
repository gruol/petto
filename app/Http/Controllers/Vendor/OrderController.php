<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use DataTables;
use Auth;
class OrderController extends Controller
{
    // Display the orders list in Yajra DataTables
    public function index(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        $pageTitle = 'Orders';
        $orderStatus = ['pending','processing','completed','cancelled'];
        if ($request->ajax()) {
            $data = Order::with('customer')->where('vendor_id',$vendor->id)->orderBy('id','DESC');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
             $action_list    = '<div class="dropdown">
             <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="ti-more-alt"></i>
             </a>

             <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

             $action_list    .= '<a class="dropdown-item btn-change-orderStatus" href="#" data-status="'.$row->status.'" data-id="'.$row->id.'"><i class="fas fa-pencil-ruler"></i> Change Order Status</a>';

             $action_list    .= '<a class="dropdown-item" href="'.route('vendor.orders.show', $row->id).'"><i class="fas fa fa-eye"></i> Order View</a>';


             return $action_list;

             $action_list    .= '</div></div>';
         })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('vendor.orders.index',compact('pageTitle','orderStatus'));
    }

    // Display a single order with items and comments
    public function show($id)
    {
        $pageTitle = "Order Details";
        $order = Order::with(['items','items.orderProduct','customer'])->findOrFail($id);
    // dd($order);
        return view('vendor.orders.show', compact('order','pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('vendor.orders.show', $id)->with('success', 'Order updated successfully.');
    }
    public function orderStatusUpdate(Request $request)
    {
        $id                     = $request->get('id');
        $status                 = $request->get('status');
        $shipment               = Order::find($id);
        $shipment->status = $status;
        $shipment->save();

        return json_encode(array("status"=>true, "message"=>"Order Status has been updated successfully!"));
    }
}
