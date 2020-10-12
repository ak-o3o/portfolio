<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//topページへのルート
Route::get('/', function () {
    return view('top');
})->name('top');

//新規登録のルート
Route::get('/register', function () {
    return view('register.register');
});
Route::post('/after_register', 'AuthController@signup')->name('after_register');

//ログインのルート
Route::get('/login', function () {
    return view('login.login');
})->name('login');
Route::post('/login/after', 'AuthController@login');

//ゲストログイン
Route::get('guest', 'AuthController@authenticate')->name('login.guest');

//ログアウトのルート
Route::get('/logout', 'AuthController@logout');

//ログイン状態
Route::group(['middleware' => 'auth'], function () {

    //ユーザ関連
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);

    // フォロー/フォロー解除を追加
    Route::post('/users/{user}/follow', 'UsersController@follow')->name('follow');
    Route::delete('/users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');

    //投稿関連
    Route::resource('posts', 'PostsController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    Route::post('posts/store', 'PostsController@store');

    //home(=/posts)表示
    Route::get('/posts', 'PostsController@index')->name('home');

    //コメント機能
    Route::resource('comments', 'CommentsController', ['only' => ['store']]);

    //いいね機能
    Route::resource('favorites', 'FavoritesController', ['only' => ['store', 'destroy']]);

    //単語帳機能
    Route::resource('vocabularies', 'VocabulariesController', ['only' => ['store', 'destroy', 'edit', 'update']]);
});

Route::get('/home/help', function () {
    return view('home.help');
});
