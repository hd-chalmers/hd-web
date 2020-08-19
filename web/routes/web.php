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
    Route::post('/active_year/{active_year}/update', 'LoehkController@update')->name('active_year');
    Route::post('/committee_member', 'LoehkController@newCommitteeMember')->name('new_committee_member');
    Route::post('/committee_member/{committee_member}', 'LoehkController@updateCommitteeMember')->name('committee_member');
    Route::delete('/committee_member/{committee_member}', 'LoehkController@deleteCommitteeMember')->name('delete_committee_member');
});


Route::get('/contact', 'ContactController@index')->name('contact');

Route::name('bgg.')->prefix('bgg')->group(static function() {
    Route::post('/search', 'BoardGameGeekController@search')->name('search');
    Route::post('/fetch/{id}', 'BoardGameGeekController@fetch')->name('fetch');
});
