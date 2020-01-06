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

Route::get('/', "IndexController@index")->name('home');
Route::resource('/committee', "CommitteeController@index");
Route::resource('/events', 'EventController');
Route::resource('/pricelist', 'PricelistController');
Route::resource('/games', 'GameController');
Route::get('/contact', 'ContactController@index')->name('contact');
