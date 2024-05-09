<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
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
Route::post('/clinic-forgot-password', [ClinicApiController::class, 'forgotPassword']);




Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware(['auth:sanctum', 'customer'])->group(function () {
	// Route::post('/send-otp', [AgentApiController::class, 'sendOtp']);
	Route::post('/customer-change-password', [CustomerApiController::class, 'changePassword']);
	Route::post('/customer-send-otp', [CustomerApiController::class, 'sendOtp']);
	Route::post('/customer-verify-otp', [CustomerApiController::class, 'verifyOtp']);
	Route::post('/customer-add-pet', [CustomerApiController::class, 'addPet']);
	Route::post('/customer-shipment-booking', [CustomerApiController::class, 'shipmentBooking']);
	Route::post('/customer-unaccompanied-booking', [CustomerApiController::class, 'unaccompaniedBooking']);

    Route::get('/customer/sync', [CustomerApiController::class, 'sync'])->name('sync');
    Route::post('/customer/post/remarks', [CustomerApiController::class, 'postRemarks']);


    Route::post('/customer-logout', [CustomerApiController::class, 'logout']);
});

// Clinics Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware(['auth:sanctum', 'clinic'])->group(function () {

	Route::post('/clinic-verify-otp', [ClinicApiController::class, 'verifyOtp']);
	Route::post('/clinic-change-password', [ClinicApiController::class, 'changePassword']);
	Route::post('/clinic-add-doctor', [ClinicApiController::class, 'addDoctor']);


    Route::post('/clinic-logout', [ClinicApiController::class, 'logout']);
	
	
});
