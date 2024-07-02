<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ClinicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
   $pageTitle = '';
   return view('admin.dashboard/dashboard')->with('pageTitle');
});

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/post-login', function () {
//     return redirect()->route('login');
// });

Route::get('/password/reset', [AuthController::class, 'forgetPassword'])->name('password.reset'); 
Route::post('/user/password-reset', [AuthController::class, 'passwordReset'])->name('user.passwordReset'); 

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('admin', [AuthController::class, 'index'])->name('login');


/* Start Admin Routes */
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    
    /* Start Dashboard Routes */
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    /* End Dashboard Routes */
    Route::get('/change-password',  [AuthController::class, 'changePassword'])->name('changePassword'); 
    Route::post('/change-password-save',  [AuthController::class, 'changePasswordSave'])->name('changePasswordSave');

    Route::get('users/ajax', [UserController::class, 'ajaxtData'])->name("users.ajax_data");
    Route::resource('users', UserController::class);

    
    Route::Post('/add-shipment-remarks',  [ShipmentController::class, 'addShipmentRemarks'])->name('add-shipment-remarks');

    Route::get('/shipment', [ShipmentController::class, 'index'])->name('shipment.index');
    Route::get('/shipment/ajaxData', [ShipmentController::class, 'ajaxtData'])->name('shipment.ajax_data');
    Route::get('/shipment/query/status_update', [ShipmentController::class, 'shipmentQueryStatusUpdate'])->name('shipment.query.status.update');
    Route::get('/shipment/status_update', [ShipmentController::class, 'shipmentStatusUpdate'])->name('shipment.status.update');
    Route::get('/shipment/payment/status_update', [ShipmentController::class, 'shipmentPaymentStatusUpdate'])->name('shipment.payment.status.update');
    Route::get('/shipment/view/{id}', [ShipmentController::class, 'shipmentView'])->name('shipment.view');
    Route::get('/shipment/edit/{id}', [ShipmentController::class, 'shipmentEdit'])->name('shipment.edit');
    Route::post('/shipment/update', [ShipmentController::class, 'shipmentUpdate'])->name('shipment.update');

    Route::get('/clinics', [ClinicController::class, 'index'])->name('clinic.index');
    Route::get('/clinics/ajaxData', [ClinicController::class, 'ajaxtData'])->name('clinic.ajax_data');
    Route::get('/clinic/query/status_update', [ClinicController::class, 'clinicQueryStatusUpdate'])->name('clinic.query.status.update');

    Route::get('/clinic/status_update', [ClinicController::class, 'clinicStatusUpdate'])->name('clinic.status.update');
    Route::get('/clinic/view/{id}', [ClinicController::class, 'clinicView'])->name('clinic.view');
   
    Route::get('/doctors', [ClinicController::class, 'doctors'])->name('doctors.index');
    Route::get('/doctors/ajaxData', [ClinicController::class, 'doctorsData'])->name('doctors.doctors_data');
    Route::get('/doctor/view/{id}', [ClinicController::class, 'doctorView'])->name('doctor.view');
    Route::get('/doctor/status_update', [ClinicController::class, 'doctorStatusUpdate'])->name('doctor.status.update');

    
    Route::get('/appointments', [ClinicController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/ajaxData', [ClinicController::class, 'appointmentsData'])->name('appointments.ajax_data');
    Route::get('/appointment/view/{id}', [ClinicController::class, 'appointmentView'])->name('appointment.view');
    // Route::get('/appointment/status_update', [ClinicController::class, 'appointmentStatusUpdate'])->name('appointment.status.update');
    



}); 
/* End Admin Routes */