<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::post('register', [RegisterController::class, 'register']); //注册接口
Route::post('login', [LoginController::class, 'login']); //登录接口

// Route::middleware('token')->group(function(){
//     Route::post('register', [RegisterController::class, 'register']);
// });
