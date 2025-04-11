<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', [Controller::class ,'index']);
Route::get('/item', [Controller::class ,'item']);
Route::get('/detail', [Controller::class ,'detail']);

Route::middleware('auth')->group(function () {
    Route::get('/mylist', [Controller::class, 'index']);
    Route::get('/mypage', [Controller::class ,'mypage']);
    Route::get('/mypage/profile', [Controller::class ,'profile']);
    Route::get('/sell', [Controller::class ,'sell']);
    Route::get('/purchase', [Controller::class ,'purchase']);
    Route::get('/purchase/address', [Controller::class ,'address']);
});