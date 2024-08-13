<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{CustomerPets,
    Shipment,
    Customer,
    Clinic,
    Doctor,AppointmentDate,AppointmentDay,AppointmentTime,Appointment,Review,VendorProductCategory,VendorProduct,ProcductComment,Order,OrderItem
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
class VendorApiController extends BaseController
{
    public function __construct()
    {


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
public function products($start,$end,$name ='',$category_id = '')
{
    $products =  VendorProduct::with(['ProductCategory' ,'Vendor' => function ($query) {
                    $query->select('id','vendor_name', 'business_name'); // Select only these columns
                }]);
    if ($name != '' && $name != '~') {
     $products->where('product_name', 'like', '%' . $name . '%');
 }
 if ($category_id != '' && $category_id > 0) {
     $products->where('category_id',  $category_id );
 }

 $products    = $products->where('is_active',1)->skip($start)->take($end);
 $total_count = $products->count();
 $products    = $products->get()->toArray();
 // dd($products->count());
  //     "total_count": "integer",
  // "page": "integer",
  // "limit": "integer"

 return $this->sendResponse($products, 'Products retrieved successfully.');

}
public function product($id)
{
    $data = [];
    $data=  VendorProduct::with(['ProductCategory' ,'Vendor' => function ($query) {
                    $query->select('id','vendor_name', 'business_name'); // Select only these columns
                }])->where('id',$id)->first()->toArray();
    $data['procduct_comments'] = $this->showCommentsByProduct($id);
    return $this->sendResponse($data, 'Product retrieved successfully.');

}
public function ProcductComment(Request $request)
{
        // dd($request->all());
        // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'product_id' => 'required|exists:vendor_products,id',
        'customer_id' => 'required|exists:customers,id',
        'parent_id' => 'nullable|exists:procduct_comments,id',
        'body' => 'required|string|max:5000',
    ]);

    if($validator->fails())
    {
        return $this->sendError( $validator->errors()->first());

    }
        // Create the comment
    $comment = ProcductComment::create([
        'product_id' => $request['product_id'],
        'customer_id' => $request['customer_id'],
        'parent_id' => $request['parent_id'] ?? null,
        'body' => $request['body'],
    ]);
        // Return a JSON response
    return $this->sendResponse(null, 'Product comments saved successfully.');

}
public function showCommentsByProduct($productId)
{
        // Get all comments for the specified product
    $comments = ProcductComment::where('product_id', $productId)
            ->whereNull('parent_id')  // Get only top-level comments
            ->with('replies')         // Load replies relationship
            ->orderBy('created_at', 'asc')
            ->get();
            return $comments;
        // Return a JSON response
        // return response()->json([
        //     'success' => true,
        //     'data' => $comments,
        // ], 200);
        }
        public function storeOrder(Request $request)
        {
            $customer   = Auth::guard('sanctum')->user();

        // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                // 'customer_id' => 'required|exists:customers,id',
                'shipping_address' => 'nullable|string|max:255',
                'billing_address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:vendor_products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);
            if($validator->fails())
            {
                return $this->sendError( $validator->errors()->first());

            }

        // Start transaction to ensure data consistency
            \DB::beginTransaction();

            try {
            // Create the order
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'province' => $request['province'] ?? null,
                    'order_date' => date('Y-m-d H:i:s'),
                    'country' => $request['country'] ?? null,
                    'city' => $request['city'] ?? null,
                    'name' => $request['name'] ?? null,
                    'email' => $request['email'] ?? null,
                    'contact_number' => $request['contact_number'] ?? null,
                    'shipping_address' => $request['shipping_address'] ?? null,
                    'billing_address' => $request['billing_address'] ?? null,
                    'total_amount' => 0,  // Placeholder, will be updated later
                ]);

                $totalAmount = 0;

            // Loop through the items and save each one
                foreach ($request['items'] as $item) {
                    $orderItem = new OrderItem([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                // Save the order item under the order
                    $order->items()->save($orderItem);

                // Calculate the total amount
                    $totalAmount += $item['quantity'] * $item['price'];
                }

            // Update the order with the correct total amount
                $order->total_amount = $totalAmount;
                $order->save();

            // Commit the transaction
                \DB::commit();

            // Return a JSON response
                // return response()->json([
                    // 'success' => true,
                    // 'message' => 'Order placed successfully.',
                // 'data' => $order->load('items'),  // Load the items relationship
            // ], 201);

                return $this->sendResponse(null, 'Order placed successfully.');


            } catch (\Exception $e) {
            // Rollback the transaction in case of error
                \DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order. Please try again.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
        public function isConfirmed(Request $request)
        {
           $order =  Order::find($request->order_id);
           $order->is_confirmed_by_customer = $request->is_confirmed;
           $order->save();
           return $this->sendResponse(null, 'Order status updated successfully.');

       }

       public function getCustomerOrders()
       {
        $data = null;
        $customer   = Auth::guard('sanctum')->user();
        $order =  Order::with('items.orderProduct')->where('customer_id',$customer->id)->get()->toArray();
      
        return $this->sendResponse($order, 'Customer Order retrieved successfully.');

    }
}
