<?php

use Illuminate\Support\Facades\Route;
// "Route"というツールを使うために必要な部品を取り込んでいます。
use App\Http\Controllers\ProductController;
// ProductControllerに繋げるために取り込んでいます
use Illuminate\Support\Facades\Auth;
// "Auth"という部品を使うために取り込んでいます。この部品はユーザー認証（ログイン）に関する処理を行います


Route::get('/', function () {
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルートです
    if (Auth::check()) {
        // ログイン状態ならば
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクトします
    } else {
        // ログイン状態でなければ
        return redirect()->route('login');
        //　ログイン画面へリダイレクトします
    }
});
// もしCompanyControllerだった場合は
// companies.index のように、英語の正しい複数形になります。


Auth::routes();

// 商品一覧画面
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録フォーム画面
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 商品追加画面
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 商品詳細画面
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 商品編集フォーム画面
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 商品更新処理
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// 商品削除処理
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


// Auth::routes();はLaravelが提供している便利な機能で
// 一般的な認証に関するルーティングを自動的に定義してくれます
// この一行を書くだけで、ログインやログアウト
// パスワードのリセット、新規ユーザー登録などのための
// ルートが作成されます。
//　つまりログイン画面に用意されたビューのリンク先がこの1行で済みます

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
