<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodMenuController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Access-Control-Allow-Origin, Authorization'); 
header('Content-Type: application/json, charset=utf-8');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword');
// Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('reset');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();

});

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/getUser', [UserController::class, 'index'])->name('index'); 
    Route::get('/getFoodMenu', [FoodMenuController::class, 'getFoodMenu'])->name('getFoodMenu'); 
    Route::get('/menus', [FoodMenuController::class]);  
    Route::get('/history', [ApiController::class, 'history'])->name('history');  
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
