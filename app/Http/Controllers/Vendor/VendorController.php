<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
  Clinic ,
  CustomerPets,Appointment,Doctor,VendorProductCategory,VendorProduct,ProcductComment
};
use Storage;

use Config;
use DB;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(Request $request)
    {
        $pageTitle           = "Dashboard";

        return view('vendor.dashboard',compact('pageTitle'));
    }

    
    public function products(Request $request)
    {
        $pageTitle = 'Products';
        if($request->ajax()){
           $data =  VendorProduct::with('ProductCategory');
           return DataTables::of($data)
           ->addColumn('action',function($data){

               $button = '<a class="btn btn-sm btn-default" href="' .route('vendor.editProduct',['id'=>$data->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
               $button .= '<a class=" btn btn-sm btn-default" href="' .route('vendor.commentProduct',['id'=>$data->id]) . '" data-toggle="tooltip" data-placement="top" title="Product Comments"><i class="fas fa-comments"></i> </a>';

               // $button .= '<a class=" btn btn-sm btn-default" href="' .route('vendor.viewProduct',['id'=>$data->id]) . '" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i> </a>';
               $button .= '<a class=" btn btn-sm btn-default delete-product"  data-prduct_id="'.$data->id.'" href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i> </a>';
               return $button ;
           })
           ->addIndexColumn()
           ->rawColumns(['action'])
           ->make(true);
       }

       return view('vendor.product.index',compact('pageTitle'));

   }
   public function addProduct()
   {
    $categories = VendorProductCategory::with('ProductCategory')->get();
    $pageTitle = "Add Product"; 
    return view('vendor.product.create',compact('categories','pageTitle'));
}
public function saveProduct(Request $request)
{
    $user = Auth::guard('vendor')->user();

    $product = New VendorProduct();
    $product->product_name = $request->product_name;
    $product->category_id = $request->category_id;
    $product->brand = $request->brand;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->sku = $request->sku;

    if($request['image1'] != null)
    {

        $image = $request['image1'];  
        // If the file exists, delete it
        $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image1'];
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image1']);
        }
        $image = str_replace(' ', '+', $image);
        $image1 = 'image1_'.$user->id.'_time_'.time().'.'.$request->image1->extension();

        Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image1,file_get_contents($image));

        $product->image1  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image1;

    }

    if($request['image2'] != null)
    {

        $image = $request['image2'];  
        // If the file exists, delete it
        $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image2'];
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image2']);
        }
        $image = str_replace(' ', '+', $image);
        $image2 = 'image2_'.$user->id.'_time_'.time().'.'.$request->image2->extension();

        Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image2,file_get_contents($image));

        $product->image2  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image2;

    }
    if($request['image3'] != null)
    {

        $image = $request['image3'];  
        // If the file exists, delete it
        $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image3'];
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image3']);
        }
        $image = str_replace(' ', '+', $image);
        $image3 = 'image3_'.$user->id.'_time_'.time().'.'.$request->image3->extension();

        Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image3,file_get_contents($image));

        $product->image3  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image3;

    }

    if($request['image4'] != null)
    {

        $image = $request['image4'];  
        // If the file exists, delete it
        $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image4'];
        if (Storage::exists($filePath)) {
            Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image4']);
        }
        $image = str_replace(' ', '+', $image);
        $image4 = 'image4_'.$user->id.'_time_'.time().'.'.$request->image4->extension();

        Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image4,file_get_contents($image));

        $product->image4  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image4;

    }
    $product->colors = $request->colors;
    $product->description = $request->description;
    $product->key_features = $request->key_features;
    $product->ingredients = $request->ingredients;
    $product->usage_instructions = $request->usage_instructions;
    $product->weight = $request->weight;
    $product->dimensions = $request->dimensions;
    $product->shipping_cost = $request->shipping_cost;
    $product->shipping_time_days = $request->shipping_time_days;
    $product->is_active = 1;
    $product->created_by_id = $user->id;
    $product->created_by_name = $user->vendor_name;

    $product->save();
        // ->with("message"=>"Product added successfully!")
    return redirect()->route('vendor.products')->with('success', 'Product added successfully!');
}
public function editProduct($id){
    $pageTitle = "Product Edit";
    $product = VendorProduct::find($id);
    $categories = VendorProductCategory::with('ProductCategory')->get();
    return view('vendor.product.edit',compact('product','pageTitle','categories'));
}
public function updateProduct(Request $request, $id)
{
   $user = Auth::guard('vendor')->user();

   $product =  VendorProduct::find($id);
   $product->product_name = $request->product_name;
   $product->category_id = $request->category_id;
   $product->brand = $request->brand;
   $product->price = $request->price;
   $product->quantity = $request->quantity;
   $product->sku = $request->sku;

   if($request['image1'] != null)
   {

    $image = $request['image1'];  
        // If the file exists, delete it
    $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image1'];
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image1']);
    }
    $image = str_replace(' ', '+', $image);
    $image1 = 'image1_'.$user->id.'_time_'.time().'.'.$request->image1->extension();

    Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image1,file_get_contents($image));

    $product->image1  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image1;

}

if($request['image2'] != null)
{

    $image = $request['image2'];  
        // If the file exists, delete it
    $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image2'];
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image2']);
    }
    $image = str_replace(' ', '+', $image);
    $image2 = 'image2_'.$user->id.'_time_'.time().'.'.$request->image2->extension();

    Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image2,file_get_contents($image));

    $product->image2  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image2;

}
if($request['image3'] != null)
{

    $image = $request['image3'];  
        // If the file exists, delete it
    $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image3'];
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image3']);
    }
    $image = str_replace(' ', '+', $image);
    $image3 = 'image3_'.$user->id.'_time_'.time().'.'.$request->image3->extension();

    Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image3,file_get_contents($image));

    $product->image3  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image3;

}

if($request['image4'] != null)
{

    $image = $request['image4'];  
        // If the file exists, delete it
    $filePath = "public/uploads/vendor_product/".$user->id.'/'.$request['image4'];
    if (Storage::exists($filePath)) {
        Storage::delete("public/uploads/vendor_product/".$user->id.'/'.$request['image4']);
    }
    $image = str_replace(' ', '+', $image);
    $image4 = 'image4_'.$user->id.'_time_'.time().'.'.$request->image4->extension();

    Storage::put("public/uploads/vendor_product/".$user->id.'/'.$image4,file_get_contents($image));

    $product->image4  = env('APP_URL')."public/storage/uploads/vendor_product/".$user->id.'/'.$image4;

}
$product->colors = $request->colors;
$product->description = $request->description;
$product->key_features = $request->key_features;
$product->ingredients = $request->ingredients;
$product->usage_instructions = $request->usage_instructions;
$product->weight = $request->weight;
$product->dimensions = $request->dimensions;
$product->shipping_cost = $request->shipping_cost;
$product->shipping_time_days = $request->shipping_time_days;
$product->is_active = 1;
$product->created_by_id = $user->id;
$product->created_by_name = $user->vendor_name;

$product->save();
        // ->with("message"=>"Product added successfully!")
return redirect()->route('vendor.products')->with('success', 'Product Updated successfully!');
}

public function viewProduct($id){
    // $product = VendorProduct::find($id);
       // Fetch the product along with comments and replies
        $product = VendorProduct::with(['comments' => function($query) {
            $query->whereNull('parent_id')->with('replies.customer', 'customer');
        }])->findOrFail($id);
        $pageTitle = 'View Product';
    return view('vendor.product.show',compact('product','pageTitle'));
}
public function reply(Request $request, ProcductComment $comment)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        ProcductComment::create([
            'product_id' => $comment->product_id,
            'vendor_id' => auth()->id(),
            'parent_id' => $comment->id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }
public function delectProduct(Request $request)
{

    $product = VendorProduct::findOrFail($request->product_id);
    $product->delete();
   return 1;
}
}
