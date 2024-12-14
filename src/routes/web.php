<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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

// 商品一覧画面
Route::get('/', [ItemController::class, 'index']);

// 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'item']);

// 出品画面
Route::middleware('auth')->group(function () {
    Route::get('/sell', [ItemController::class, 'sell']);
});
Route::post('/sell', [ItemController::class, 'sellStore']);

// プロフィール画面
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [UserController::class, 'profile']);
});

// プロフィール編集画面
Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'profileEdit']);
});
Route::patch('/mypage/profile', [UserController::class, 'profileEditUpdate']);