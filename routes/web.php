<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//新規登録
Route::post('/user_register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('user.register');

//ホーム画面に飛ぶ
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//リスト画面に飛ぶ
Route::get('/list', [ProductController::class, 'list'])->name('list');

//新規登録に飛ぶ
Route::get('/registShow', [ProductController::class, 'registShow'])->name('regist.show');

//商品の新規登録の処理　//データベース変更の時はpostを使う
Route::post('/regist', [ProductController::class, 'regist'])->name('regist');

//商品を削除する
Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete');

//詳細画面に飛ぶ
Route::get('/detailShow/{id}', [ProductController::class, 'detailShow'])->name('detail.show');

//編集画面に飛ぶ
Route::get('/editShow/{id}', [ProductController::class, 'editShow'])->name('edit.show');

//編集する
Route::put('/edit/{id}', [ProductController::class, 'edit'])->name('edit');

//検索する
Route::get('/search', [ProductController::class, 'search'])->name('search');