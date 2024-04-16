<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/post-login', function () {
    return redirect()->route('login');
});

Route::get('/password/reset', [AuthController::class, 'forgetPassword'])->name('password.reset'); 
Route::post('/user/password-reset', [AuthController::class, 'passwordReset'])->name('user.passwordReset'); 


Route::get('admin', [AuthController::class, 'index'])->name('login');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
/* Start Admin Routes */
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    /* Start Dashboard Routes */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    /* End Dashboard Routes */
    Route::get('/change-password',  [AuthController::class, 'changePassword'])->name('changePassword'); 
    Route::post('/change-password-save',  [AuthController::class, 'changePasswordSave'])->name('changePasswordSave');

    Route::get('users/ajax', [UserController::class, 'ajaxtData'])->name("users.ajax_data");
    Route::resource('users', UserController::class);

}); 
/* End Admin Routes */