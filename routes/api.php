<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\VendorApiController;
use App\Http\Controllers\Api\ClinicApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/customer-login', [CustomerApiController::class, 'login']);
Route::post('/customer-sign-up', [CustomerApiController::class, 'store']);
Route::post('/customer-forgot-password-otp', [CustomerApiController::class, 'sendOtp']);

Route::post('/customer-forgot-password', [CustomerApiController::class, 'forgotPassword']);

Route::get('/test-500-error', 'CustomerApiController@testError')->name('test.error');


Route::post('/clinic-sign-up', [ClinicApiController::class, 'clinicStore']);
Route::post('/clinic-login', [ClinicApiController::class, 'login']);
Route::post('/clinic-forgot-password-otp', [ClinicApiController::class, 'sendOtp']);
	Route::post('/clinic-send-otp', [ClinicApiController::class, 'sendOtp']);

Route::post('/clinic-forgot-password', [ClinicApiController::class, 'forgotPassword']);




Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware(['auth:sanctum', 'customer'])->group(function () {
	// Route::post('/send-otp', [AgentApiController::class, 'sendOtp']);
	Route::post('/customer-change-password', [CustomerApiController::class, 'changePassword']);
	Route::post('/customer-send-otp', [CustomerApiController::class, 'sendOtp']);
	Route::post('/customer-verify-otp', [CustomerApiController::class, 'verifyOtp']);
	Route::post('/customer-add-pet', [CustomerApiController::class, 'addPet'])->middleware('OTPVerification');;
	Route::post('/customer-update-pet', [CustomerApiController::class, 'updatePet'])->middleware('OTPVerification');;
	Route::post('/customer-delete-pet', [CustomerApiController::class, 'deletePet'])->middleware('OTPVerification');;
	Route::post('/customer-update', [CustomerApiController::class, 'updateCustomer'])->middleware('OTPVerification');;

	Route::post('/customer-shipment-booking', [CustomerApiController::class, 'shipmentBooking'])->middleware('OTPVerification');
	Route::post('/customer-unaccompanied-booking', [CustomerApiController::class, 'unaccompaniedBooking'])->middleware('OTPVerification');
	Route::post('/confirm-unaccompanied-shipment', [CustomerApiController::class, 'confirmUnaccompaniedBooking'])->middleware('OTPVerification');


    Route::get('/customer/sync', [CustomerApiController::class, 'sync'])->name('sync')->middleware('OTPVerification');
    Route::get('/customer/data', [CustomerApiController::class, 'customerData'])->name('customerData')->middleware('OTPVerification');;
    Route::get('/customer/shipments', [CustomerApiController::class, 'customerShipments'])->name('customerShipments');
    Route::get('/customer/pets', [CustomerApiController::class, 'customerPets'])->name('customerPets')->middleware('OTPVerification');
    Route::get('/customer/pet/{id}', [CustomerApiController::class, 'customerPet'])->name('customerPet')->middleware('OTPVerification');
    Route::get('/countries', [CustomerApiController::class, 'countries'])->name('countries')->middleware('OTPVerification');
    Route::post('/customer/post/remarks', [CustomerApiController::class, 'postRemarks'])->middleware('OTPVerification');

	Route::post('/book/appointment', [ClinicApiController::class, 'bookAppointment'])->middleware('OTPVerification');

    Route::post('/customer-logout', [CustomerApiController::class, 'logout'])->middleware('OTPVerification');
	Route::get('/customer-appointments', [CustomerApiController::class, 'customerAppointments'])->middleware('OTPVerification');
});

// Clinics Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware(['auth:sanctum', 'clinic'])->group(function () {
	Route::post('/clinic-send-otp', [ClinicApiController::class, 'sendOtp']);
	
	Route::post('/clinic-verify-otp', [ClinicApiController::class, 'verifyOtp']);
	Route::post('/clinic-change-password', [ClinicApiController::class, 'changePassword']);
	Route::post('/clinic-add-doctor', [ClinicApiController::class, 'addDoctor'])->middleware('OTPVerification');
	Route::post('/clinic-update', [ClinicApiController::class, 'updateClinic'])->middleware('OTPVerification');
	Route::post('/clinic-update-doctor', [ClinicApiController::class, 'updateDoctor'])->middleware('OTPVerification');
    Route::get('/clinic-doctors/{id?}', [ClinicApiController::class, 'doctors'])->name('getDoctors')->middleware('OTPVerification');
    Route::post('/clinic-doctors/{id?}', [ClinicApiController::class, 'doctors'])->name('doctors')->middleware('OTPVerification');
	Route::post('/update/appointment', [ClinicApiController::class, 'updateAppointment'])->middleware('OTPVerification');
	Route::get('/clinic-appointments', [ClinicApiController::class, 'clinicAppointment'])->middleware('OTPVerification');
	Route::post('/add/review', [ClinicApiController::class, 'addReview'])->middleware('OTPVerification');
	Route::get('/doctor-reviews/{doc_id}', [ClinicApiController::class, 'getDoctorReview'])->middleware('OTPVerification');

    Route::post('/clinic-logout', [ClinicApiController::class, 'logout']);
	
	//e-commerce Routes 


	
	Route::get('/products/{start}/{end}/{name?}/{category_id?}', [VendorApiController::class, 'products']);
	Route::get('/product/{id}', [VendorApiController::class, 'product']);
    Route::post('/store-comments', [VendorApiController::class, 'ProcductComment']);
    Route::get('/product/{productId}/comments', [VendorApiController::class, 'showCommentsByProduct']);
    Route::post('/order-save', [VendorApiController::class, 'storeOrder']);
    Route::post('/is-confirm-order', [VendorApiController::class, 'isConfirmed']);
    Route::get('/get-customer-orders', [VendorApiController::class, 'getCustomerOrders']);

});
