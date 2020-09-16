<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Captcha;

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


Route::get('/', [IndexController::class, 'index']);
Route::get('about', [IndexController::class, 'about']);
Route::get('bbs', [IndexController::class, 'bbs']);
Route::get('contact', [IndexController::class, 'contact']);

Route::get('verify', [LoginController::class, 'verify']);


Route::get('logout', [IndexController::class, 'logout']);