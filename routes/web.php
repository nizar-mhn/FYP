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
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'logout'])->name('logout');
Route::post('/', [LoginController::class, 'login'])->name('logged');

Route::get('/testing', [App\Http\Controllers\userController::class, 'index']);

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web', 'auth:student'], 'prefix' => 'students'], function () {
    Route::get('/mainPage', [App\Http\Controllers\fileController::class, 'index'])->name('document');
    Route::get('/history', [App\Http\Controllers\historyController::class, 'index'])->name('studentHistory');
    Route::get('/{fileID}', function ($fileID) {
        return view('/students/fileInfo')->with('fileID', $fileID);
    });
    Route::post('/payment',[App\Http\Controllers\paymentController::class, 'index'])->name('payment');
    Route::post('/',[App\Http\Controllers\paymentController::class, 'orderCreate'])->name('orderCreate');
    Route::get('/profile', [App\Http\Controllers\profileController::class, 'index'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\profileController::class, 'index'])->name('profile');
    Route::post('/documents/upload', [App\Http\Controllers\fileController::class, 'update'])->name('document.update');
    Route::get('/documents/download/{documentId}', [App\Http\Controllers\fileController::class, 'download'])->name('document.download');
    Route::get('/documents/delete/{documentId}', [App\Http\Controllers\fileController::class, 'destroy'])->name('document.destroy');
});

Route::group(['middleware' => ['web', 'auth:admin']], function () {
    Route::get('admins/admin_main', [App\Http\Controllers\adminController::class, 'index'])->name('adminMainPage');
    Route::get('admins/status/{orderID}/{status}', [App\Http\Controllers\adminController::class, 'status'])->name('orderStatus');
    Route::get('admins/admin_report', [App\Http\Controllers\adminController::class, 'report'])->name('adminReport');
    Route::get('/{fileID}/{orderID}', function ($fileID,$orderID) {
        return view('/admin/fileInfo')->with('fileID', $fileID)->with('orderID',$orderID);
    });
    Route::get('/download/{orderID}', [App\Http\Controllers\fileController::class, 'download'])->name('pdfDownload');
});

Route::group(['middleware' => ['web', 'auth:staff'], 'prefix' => 'staffs'], function () {
    Route::get('/staff_main', [App\Http\Controllers\fileController::class, 'staffindex'])->name('staffMainPage');
    Route::post('/staff_main/upload', [App\Http\Controllers\fileController::class, 'staffupdate'])->name('document.staffupdate');
    Route::get('/{fileID}', function ($fileID) {
        return view('/staff/fileInfo')->with('fileID', $fileID);
    });
});
