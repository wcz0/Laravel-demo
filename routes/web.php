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

Route::get('logout', [IndexController::class, 'logout']);
Route::any('checkLogined', [IndexController::class, 'checkLogined']);
Route::post('checkSession', [IndexController::class, 'checkSession']);


Route::prefix('login')->group(function(){
    Route::post('cookieLogin', [LoginController::class, 'cookieLogin']);
    Route::post('checkCode', [LoginController::class, 'checkCode']);
    Route::post('register', [LoginController::class, 'register']);
    Route::post('register2', [LoginController::class, 'register2']);
    Route::post('sendCodeSmsEmail', [LoginController::class, 'sendCodeSmsEmail']);

    Route::post('login', [LoginController::class, 'login']);
    Route::get('verify', [LoginController::class, 'verify']);
    Route::any('test', [LoginController::class, 'test']);
    Route::any('test1', [LoginController::class, 'test1']);
    
});

Route::prefix('profile')->group(function(){
    Route::get('userInfo', [ProfileController::class, 'userInfo']);
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('account', [ProfileController::class, 'account']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('avatar', [ProfileController::class, 'avatar']);

});
