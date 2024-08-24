<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Redirect the root URL to the /login page
Route::get('/', function () {
    return redirect('/login');
});

// User Login routes (admin&vendor)
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);

// User Register routes
Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register']);

// User Dashboard route
Route::get('dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('user.dashboard');


Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::post('/user/profile/update/{id}', [UserController::class, 'updateProfile'])->name('user.updateProfile');

//User Logout
Route::post('logout', [UserController::class, 'logout'])->name('logout');

// Admin profile routes 
Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
Route::post('/admin/profile/update/{id}', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
//Admin update status vendor
Route::put('/vendor/{id}', [VendorController::class, 'updatestatus'])->name('vendor.update');
// Define the route for the admin dashboard
// Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');

// Define the route for list vendor submissions & accepted
Route::get('/vendor/submissions', [VendorController::class, 'showAllSubmission'])->name('vendor.submissions');
Route::get('/vendor/accepted', [VendorController::class, 'showAllSubmission2'])->name('vendor.accepted');


// Define the route for list vendor can register/view/delete
Route::get('/vendor/register', [VendorController::class, 'showRegistrationForm'])->name('vendor.register'); 
Route::post('/vendor/register', [VendorController::class, 'register'])->name('vendor.register');
Route::get('/vendor/submission', [VendorController::class, 'showSubmission'])->name('vendor.submission');
Route::delete('/vendor/submissions/{id}', [VendorController::class, 'deleteSubmission'])->name('vendor.delete');




require __DIR__.'/auth.php';
