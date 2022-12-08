<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

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


//USER
//Do not required auth
Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'index'])->name('logout');
Route::post('/', [LoginController::class, 'login'])->name('logged');

//ADMIN
//Do not required auth
// Route::get('/adminLogin', [AdminLoginController::class, 'index'])->name('adminLogin');
// Route::post('/adminLogin', [AdminLoginController::class, 'store']);

// //SUPPLIER
// Route::get('/supplierLogin', [SupplierLoginController::class, 'index'])->name('supplierLogin');
// Route::post('/supplierLogin', [SupplierLoginController::class, 'store'])->name('supplierLogin');






Route::get('/testing', [App\Http\Controllers\userController::class, 'index']);

Route::get('/history', function () {
    return view('students/history');
});

Route::get('/user', function () {
    return view('students/user');
});




Route::get('/documents/uploadFile', [App\Http\Controllers\fileController::class, 'show'])->name('document');
Route::post('/documents/upload', [App\Http\Controllers\fileController::class, 'update'])->name('document.update');
Route::get('/documents/download/{documentId}', [App\Http\Controllers\fileController::class, 'download'])->name('document.download');
Route::get('/documents/delete/{documentId}', [App\Http\Controllers\fileController::class, 'destroy'])->name('document.destroy');

Route::get('/welcome', function () {
    return view('welcome');
});
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web','auth:student'], 'prefix' => 'students'], function () {
    Route::get('/mainPage', [App\Http\Controllers\fileController::class, 'index'])->name('document');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
});

Route::group(['middleware' => ['web','auth:admin'], 'prefix' => 'admins'], function () {
    Route::get('/mainPage', function () {
        return view('admin/admin_main');
    })->name('adminMainPage');
    
});

Route::group(['middleware' => ['web','auth:staff'], 'prefix' => 'staffs'], function () {
    Route::get('/mainPage', function () {
        return view('staff/staff_main');
    })->name('staffMainPage');
    
    Route::get('/orders', function () {
        return view('staff/staff_order');
    })->name('order');
});
