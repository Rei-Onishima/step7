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
    // Index
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    
    // Create
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    
    // Store
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    
    // Show
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Edit
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    
    // Update
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    
    // Destroy
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
