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
Route::get('/pricelist/download', 'PricelistController@download');
Route::resource('/pricelist', 'PricelistController');
Route::post('/games/save', 'GameController@save');
Route::resource('/games', 'GameController');
Route::get('/contact', 'ContactController@index')->name('contact');

Route::get('/home', 'HomeController@index')->name('home');
