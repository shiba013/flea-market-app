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
Route::get('/item/{item_id}', [MypageController::class ,'detail']);


Route::middleware('auth')->group(function ()
{
    Route::get('/mypage/profile', [AuthController::class, 'address']);
    Route::post('/mypage/profile', [AuthController::class, 'store']);
});


Route::middleware('auth')->group(function ()
{
    Route::get('/mylist', [AuthController::class, 'mylist']);
    Route::get('/mypage', [MypageController::class ,'mypage']);
    Route::get('/sell', [ItemController::class ,'sell']);
    Route::get('/purchase', [OrderController::class ,'purchase']);
    Route::post('/mylist', [OrderController::class ,'store']);
    Route::get('/purchase/address', [OrderController::class ,'shippingAddress']);
    Route::post('/purchase', [OrderController::class ,'edit']);
});