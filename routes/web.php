<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\userController;

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
Route::get('/register', [userController::class, 'index'])->name('register');
Route::get('/register/userProg', [userController::class, 'selectUser'])->name('selectUser');
Route::get('/register/userInfo', [userController::class, 'selectProg'])->name('selectProgram');
Route::get('/register/userError', [userController::class, 'validation'])->name('validation');
Route::post('/registerUser', [userController::class, 'createUser'])->name('registerUser');
Route::get('account/verify/{token}', [userController::class, 'verifyStudentAccount'])->name('student.verify');
Route::get('accountStaff/verify/{token}', [userController::class, 'verifyStaffAccount'])->name('staff.verify');
Route::get('forgotPassword', [userController::class, 'forgotPassword'])->name('forgotPassword');
Route::get('forgotPassword/resetPassword', [userController::class, 'resetPassword'])->name('resetPassword');
Route::get('forgotPassword/emailConfirmed/{token}/{email}/{user}', [userController::class, 'confirmEmail'])->name('confirmEmail');
Route::get('forgotPassword/passwordReset', [userController::class, 'passwordReset'])->name('passwordReset');

Route::get('/testing', [App\Http\Controllers\userController::class, 'create']);
Route::get('/map', function () {
    return view('students.choosePickUp');
})->name('login');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web', 'auth:student'], 'prefix' => 'students'], function () {
    Route::get('/mainPage', [App\Http\Controllers\fileController::class, 'index'])->name('document');
    Route::get('/history', [App\Http\Controllers\historyController::class, 'index'])->name('studentHistory');
    Route::get('/{fileID}', function ($fileID) {
        return view('/students/fileInfo')->with('fileID', $fileID);
    });
    Route::post('/invoiceView', [App\Http\Controllers\invoiceController::class, 'viewInvoice'])->name('invoiceView');
    Route::post('/history', [App\Http\Controllers\invoiceController::class, 'downloadInvoice'])->name('downloadInvoice');
    Route::post('/pickup', [App\Http\Controllers\paymentController::class, 'chooseLocation'])->name('chooseLocation');
    Route::post('/payment', [App\Http\Controllers\paymentController::class, 'index'])->name('payment');
    Route::post('/', [App\Http\Controllers\paymentController::class, 'orderCreate'])->name('orderCreate');
    Route::get('/profile', [App\Http\Controllers\profileController::class, 'index'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\profileController::class, 'index'])->name('profile');
    Route::post('/documents/upload', [App\Http\Controllers\fileController::class, 'update'])->name('document.update');
    Route::get('/documents/download/{documentId}', [App\Http\Controllers\fileController::class, 'download'])->name('document.download');
    Route::get('/documents/delete/{documentId}', [App\Http\Controllers\fileController::class, 'destroy'])->name('document.destroy');
});

Route::group(['middleware' => ['web', 'auth:staff'], 'prefix' => 'staffs'], function () {
    Route::get('/staff_main', [App\Http\Controllers\fileController::class, 'staffindex'])->name('staffMainPage');
    Route::post('/staff_main/upload', [App\Http\Controllers\fileController::class, 'staffupdate'])->name('document.staffupdate');
    Route::get('/updateFile', [App\Http\Controllers\staffController::class, 'setAvailability'])->name('updateAvailability');
    Route::get('/{fileID}', function ($fileID) {
        return view('/staff/fileInfo')->with('fileID', $fileID);
    });
    
});

Route::group(['middleware' => ['web', 'auth:admin']], function () {
    Route::get('admins/admin_main', [App\Http\Controllers\adminController::class, 'index'])->name('adminMainPage');
});

Route::group(['middleware' => ['web', 'auth:supplier']], function () {
    Route::get('suppliers/supplier_main', [App\Http\Controllers\supplierController::class, 'index'])->name('supplierMainPage');
    Route::get('suppliers/status/{orderID}/{status}', [App\Http\Controllers\supplierController::class, 'status'])->name('orderStatus');
    Route::get('suppliers/supplier_report', [App\Http\Controllers\supplierController::class, 'report'])->name('supplierReport');
    Route::get('suppliers/reports', [App\Http\Controllers\supplierController::class, 'report'])->name('reportGenerate');
    Route::get('/download/{fileID}', [App\Http\Controllers\fileController::class, 'download'])->name('pdfDownload');
    Route::get('/{fileID}/{orderID}', function ($fileID, $orderID) {
        return view('/suppliers/fileInfo')->with('fileID', $fileID)->with('orderID', $orderID);
    });
});
