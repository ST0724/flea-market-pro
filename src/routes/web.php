<?php

use Illuminate\Support\Facades\Route;
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
Route::post('/', [ItemController::class, 'indexSearch']);

// 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'item']);

Route::middleware('auth')->group(function () {
    Route::post('/item/{item_id}', [ItemController::class, 'comment']);
});

Route::middleware('auth')->group(function () {
    Route::post('/like/{item_id}', [ItemController::class, 'like']);
});

// 購入画面
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);
});

Route::middleware('auth')->group(function () {
    Route::post('/purchase/{item_id}', [ItemController::class, 'purchaseStore']);
});

// 住所変更ページ
Route::middleware('auth')->group(function () {
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'address']);
});

Route::middleware('auth')->group(function () {
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'addressStore']);
});

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

// チャット画面
Route::middleware('auth')->group(function () {
    Route::get('/chat/{transaction_id}', [UserController::class, 'chat']);
    Route::post('/chat/{transaction_id}', [UserController::class, 'chatStore']);
    Route::delete('/chat/{transaction_id}/delete', [UserController::class, 'chatDestroy']);
});