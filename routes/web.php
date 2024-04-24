<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShipmentController;

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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/post-login', function () {
//     return redirect()->route('login');
// });

Route::get('/password/reset', [AuthController::class, 'forgetPassword'])->name('password.reset'); 
Route::post('/user/password-reset', [AuthController::class, 'passwordReset'])->name('user.passwordReset'); 


// Route::get('admin', [AuthController::class, 'index'])->name('login');


/* Start Admin Routes */
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    /* Start Dashboard Routes */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    


}); 
/* End Admin Routes */