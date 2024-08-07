<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{CustomerPets,
    Shipment,
    Customer,
    Clinic,
    Doctor,AppointmentDate,AppointmentDay,AppointmentTime,Appointment,Review,VendorProductCategory,VendorProduct
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
    if ($name != '' ) {
       $products->where('product_name', 'like', '%' . $name . '%');
    }
    if ($category_id != '' && $category_id > 0) {
       $products->where('category_id',  $category_id );
    }

    $products = $products->where('is_active',1)->skip($start)->take($end)->get()->toArray();
    return $this->sendResponse($products, 'Products retrieved successfully.');
    
}
public function product($id)
{
   $product =  VendorProduct::with(['ProductCategory' ,'Vendor' => function ($query) {
                    $query->select('id','vendor_name', 'business_name'); // Select only these columns
                }])->where('id',$id)->first()->toArray();;
    return $this->sendResponse($product, 'Product retrieved successfully.');
   
}

}
