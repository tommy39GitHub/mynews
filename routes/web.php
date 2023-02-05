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

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Admin\NewsController;
Route::controller(NewsController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('news/create', 'add')->name('news.add');
    Route::post('news/create', 'create')->name('news.create');
    
    Route::get('news', 'index')->name('news.index');
    
    Route::get('news/edit', 'edit')->name('news.edit');
    Route::post('news/edit', 'update')->name('news.update');
    
    Route::get('new/delete', 'delete')->name('news.delete');
    /*削除機能は画面を持たず、viewテンプレートは不要 */
});


/*課題３「http://XXXXXX.jp/XXX というアクセスが来たときに、 
AAAControllerのbbbというAction に渡すRoutingの設定」*/
use App\Http\Controllers\XXX\AAAController;
Route::controller(AAAController::class)->prefix('XXX')->group(function() {
    Route::get('bbb');
});

 /*laravel07 課題2, 3　 ログインしていない状態で /admin/profile/create にアクセス
 した場合はログイン画面にリダイレクト、
 こちらをログインしていない状態で /admin/profile/edit にアクセスした場合に
 ログイン画面にリダイレクトされる
  laravel08 admin/profile/create に POSTメソッドでアクセスしたら 
ProfileController の create Action に割り当てるように設定してください

 */
 
use App\Http\Controllers\Admin\ProfileController;
Route::controller(ProfileController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('profile/create', 'add')->name('profile.add');
    
    // Route::get('profile/edit', 'update')->name('profile.update');
    Route::get('profile/edit', 'edit')->name('profile.edit');
    Route::post('profile/edit', 'update')->name('profile.update');
    
    Route::post('profile/create', 'create')->name('profile.create');
    
    
    
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
