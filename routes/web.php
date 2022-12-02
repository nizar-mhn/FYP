<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('students/main');
});

Route::get('/history', function () {
    return view('students/history');
});

Route::get('/user', function () {
    return view('students/user');
});

Route::get('/staff', function () {
    return view('staff/staff_main');
});

Route::get('/orders', function () {
    return view('staff/staff_order');
});


Route::get('/documents', [App\Http\Controllers\fileController::class, 'index'])->name('document');
Route::get('/documents/uploadFile', [App\Http\Controllers\fileController::class, 'show'])->name('document');
Route::post('/documents/upload', [App\Http\Controllers\fileController::class, 'update'])->name('document.update');
Route::get('/documents/download/{documentId}', [App\Http\Controllers\fileController::class, 'download'])->name('document.download');
Route::get('/documents/delete/{documentId}', [App\Http\Controllers\fileController::class, 'destroy'])->name('document.destroy');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
