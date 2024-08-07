<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\Auth\LoginController;
use App\Http\Controllers\Vendor\VendorController;

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

// Route::get('/post-login', function () {
//     return redirect()->route('login');
// });
// Route::prefix('vendor')->name('vendor.')->group(function () {

Auth::routes();
Route::middleware(['auth.vendor'])->group(function() {

    Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard'); 
    Route::get('products', [VendorController::class, 'products'])->name('products'); 
    Route::get('add-product', [VendorController::class, 'addProduct'])->name('addProduct'); 
    Route::post('save-product', [VendorController::class, 'saveProduct'])->name('saveProduct'); 
    Route::get('edit-product/{id}', [VendorController::class, 'editProduct'])->name('editProduct'); 
    Route::post('update-product/{id}', [VendorController::class, 'updateProduct'])->name('updateProduct'); 
    Route::get('view-product/{id}', [VendorController::class, 'viewProduct'])->name('viewProduct'); 
    Route::get('delete-product', [VendorController::class, 'delectProduct'])->name('delectProduct'); 



});
// 
// Route::get('/password/reset', [AuthController::class, 'forgetPassword'])->name('password.reset'); 
// Route::post('/user/password-reset', [AuthController::class, 'passwordReset'])->name('user.passwordReset'); 

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

