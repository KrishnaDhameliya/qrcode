<?php

use App\Http\Controllers\QRController;
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
    return view('welcome');
});
Route::get('qrcode',[QRController::class,'generateQrCode']);
Route::get('qrscan',[QRController::class,'index']);
Route::get('create',[QRController::class,'create']);