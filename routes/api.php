<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\OrderController;

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

Route::get("/auth/error",function (){
    return response()->json(\App\common\ResultRequest::RESULT_ERROR("인증이 필요합니다."));
})->name("authError");

Route::prefix("user")->group( function (){
    Route::post("/signup",[AuthUserController::class, 'signUp']);
    Route::post("/login",[AuthUserController::class, 'login'])->name("login");
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/logout",[AuthUserController::class, 'logout']);
        Route::get("/orders",[AuthUserController::class,'orders']);
        Route::get("/orders/{id}",[AuthUserController::class,'ordersDetail']);
    });

});

Route::prefix("goods")->group( function (){
    Route::get("/",[OrderController::class,'search']);
    Route::middleware('auth:sanctum')->post("/orders",[OrderController::class, 'orderGoods']);
});

