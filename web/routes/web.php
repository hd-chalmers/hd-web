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
Route::middleware('auth')->prefix('loehk')->name('loehk.')->group(function() {
    Route::get('/', 'LoehkController@index')->name('index');
    Route::get('/stats', 'LoehkController@stats')->name('stats');
    Route::get('/active_year', 'LoehkController@active_year')->name('active_year');
    Route::post('/active_year/new', 'LoehkController@newActiveYear')->name('new_active_year');
    Route::post('/active_year/{active_year}/update', 'LoehkController@update')->name('update_active_year');
    Route::post('/committee_member', 'LoehkController@newCommitteeMember')->name('new_committee_member');
    Route::post('/committee_member/{committee_member}', 'LoehkController@updateCommitteeMember')->name('committee_member');
    Route::delete('/committee_member/{committee_member}', 'LoehkController@deleteCommitteeMember')->name('delete_committee_member');
    Route::post('/event/new', 'LoehkController@newEvent')->name('new_event');
    Route::post('/event', 'LoehkController@getEvents')->name('events');
    Route::delete('/event/{event}', 'LoehkController@deleteEvent')->name('delete_event');
    Route::post('/event/{event}/update', 'LoehkController@updateEvent')->name('update_event');
    Route::get('/prices', 'LoehkController@getPrices')->name('prices');
    Route::post('/prices', 'LoehkController@newProduct')->name('newProduct');
    Route::patch('/prices/{product}', 'LoehkController@updateProduct')->name('updateProduct');
    Route::delete('/prices/{product}', "LoehkController@deleteProduct");
    Route::get('/streck/print', 'StreckController@print')->name('streckPrint');
});

Route::get('/counter', 'CounterController@index');
Route::post('/counter/increase', 'CounterController@increase');
Route::post('/counter/decrease', 'CounterController@decrease');
Route::post('/counter/get', 'CounterController@get');
Route::post('/counter/reset', 'CounterController@reset');


Route::get('/contact', 'ContactController@index')->name('contact');

Route::name('bgg.')->prefix('bgg')->group(static function() {
    Route::post('/search', 'BoardGameGeekController@search')->name('search');
    Route::post('/fetch/{id}', 'BoardGameGeekController@fetch')->name('fetch');
});
