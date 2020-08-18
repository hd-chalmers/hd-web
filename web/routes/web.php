<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', "IndexController@index")->name('index');

Auth::routes();
Route::resource('/committee', "CommitteeController");
Route::resource('/event', 'EventController');
Route::resource('/account', 'AccountController')->middleware('auth');
Route::get('/products/download', 'ProductController@download');
Route::resource('/products', 'ProductController')->except(['show']);
Route::post('/games/save', 'GameController@save');
Route::resource('/games', 'GameController');
Route::get('/contact', 'ContactController@index')->name('contact');

Route::get('/door', 'IndexController@door')->name('door');

Route::get('/contact', 'ContactController@index')->name('contact');

Route::name('bgg.')->prefix('bgg')->group(static function() {
    Route::post('/search', 'BoardGameGeekController@search')->name('search');
    Route::post('/fetch/{id}', 'BoardGameGeekController@fetch')->name('fetch');
});
