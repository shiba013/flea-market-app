<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StripeWebhookController;

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

Route::get('/register', [AuthController::class ,'register']);
Route::post('/register', [AuthController::class ,'createUser']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginUser']);
Route::get('/', [MypageController::class ,'home']);
Route::get('/item/{item_id}', [MypageController::class ,'showItem']);
Route::get('/search', [MypageController::class, 'search']);
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::middleware('auth')->group(function ()
{
    Route::get('/mypage', [MypageController::class ,'mypage']);
    Route::get('/mypage/profile', [AuthController::class, 'address']);
    Route::post('/mypage/profile', [AuthController::class, 'store']);
    Route::get('/sell', [TransactionController::class ,'sell']);
    Route::post('/sell', [TransactionController::class, 'exhibit']);
    Route::get('/purchase/{item_id}', [TransactionController::class ,'purchase']);
    Route::get('/purchase/address/{item_id}', [TransactionController::class ,'shippingAddress']);
    Route::post('/purchase/address/{item_id}', [TransactionController::class ,'edit']);
    Route::post('/purchase/{item_id}', [TransactionController::class ,'store']);
    Route::post('/item/{item_id}/like', [MypageController::class ,'like']);
    Route::post('/item/{item_id}/comment', [MypageController::class, 'comment']);
});
