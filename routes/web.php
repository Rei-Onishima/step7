<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // ログイン状態ならば
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクト
    } else {
        // ログイン状態でなければ
        return redirect()->route('login');
        //　ログイン画面へリダイレクト
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});
