<?php

namespace App\Http\Controllers\Vendor\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;


use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\{
    Vendor,
    VendorProductCategory
};
use Config;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function validator(array $data)
    {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'vendor_name' => ['required', 'string', 'max:255'],
            'cnic' => ['required', 'integer', 'unique:vendors'],
            'ntn' => ['required', 'unique:vendors'],
            'contact' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vendors'],
            'password' => 'required|min:8|max:15|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'min:8',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
     public function showRegistrationForm()
    {
        $product_category = DB::table('product_category')->where('is_active',1)->get();
        return view('vendor.register',compact('product_category'));
    }
        public function register(Request  $request)
    {
        $validator =  $this->validator($request->toArray());
        if($validator->fails())
        {
           return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }


        $data = $request->all();
         
        // dd($data['product_category']);
        $vendor =  Vendor::create([
            'business_name' => $data['business_name'],
            'vendor_name' => $data['vendor_name'],
            'ntn' => $data['ntn'],
            'cnic' => $data['cnic'],
            'contact' => $data['contact'],
            'address' => $data['address'],
            'city' => $data['city'],
            'web_link' => $data['web_link'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
         if (!empty($request->product_category) > 0) {
             foreach ($request->product_category as $key => $product_category) {
                $obj                = new VendorProductCategory();
                $obj->category_id   = $product_category;
                $obj->vendor_id     =  $vendor->id;
                $obj->save();
             }
         }
        $details = [
            'title' => Config::get('constants._PROJECT_NAME'),
            'vendor_name' => $request->vendor_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'business_name' => $request->business_name
        ];

        // \Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\eCommerceVendorSignupAdmin($details));

        return back()->with('success',"Vendor Created and sent for approval ");
    }
}
