<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;

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

Route::get('/', [MypageController::class ,'index']);
Route::get('/item/{item_id}', [MypageController::class ,'introduction']);

Route::middleware('auth')->group(function ()
{
    Route::get('/mypage/profile', [AuthController::class, 'address']);
    Route::post('/mypage/profile', [AuthController::class, 'store']);
});
Route::middleware('auth')->group(function ()
{
    Route::get('/', [MypageController::class, 'mylist']);
    Route::get('/item/{item_id}', [MypageController::class ,'detail']);
    Route::get('/mypage', [MypageController::class ,'mypage']);
    Route::get('/sell', [ItemController::class ,'sell']);
    Route::get('/purchase/{item_id}', [OrderController::class ,'purchase']);
    Route::get('/purchase/address/{item_id}', [OrderController::class ,'shippingAddress']);
    Route::post('/purchase/address/{item_id}', [OrderController::class ,'edit']);
    Route::post('/purchase/{item_id}', [OrderController::class ,'store']);
});