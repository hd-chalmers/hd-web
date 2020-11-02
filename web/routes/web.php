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

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BoardGameGeekController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoehkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StreckController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');

Auth::routes();
Route::resource('/committee', CommitteeController::class);
Route::resource('/event', EventController::class);
Route::resource('/account', AccountController::class)->middleware('auth');
Route::get('/products/download', [ProductController::class, 'download']);
Route::resource('/products', ProductController::class)->except(['show']);
Route::post('/games/save', [GameController::class, 'save']);
Route::resource('/games', GameController::class);
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/door', [IndexController::class, 'door'])->name('door');
Route::middleware('auth')->prefix('loehk')->name('loehk.')->group(function() {
    Route::get('/', [LoehkController::class, 'index'])->name('index');
    Route::get('/stats', [LoehkController::class, 'stats'])->name('stats');

    Route::get('/active_year', [LoehkController::class, 'active_year'])->name('active_year');
    Route::post('/active_year/new', [LoehkController::class, 'newActiveYear'])->name('new_active_year');
    Route::post('/active_year/{active_year}/update', [LoehkController::class, 'update'])->name('update_active_year');

    Route::post('/committee_member', [LoehkController::class, 'newCommitteeMember'])->name('new_committee_member');
    Route::post('/committee_member/{committee_member}', [LoehkController::class, 'updateCommitteeMember'])->name('committee_member');
    Route::delete('/committee_member/{committee_member}', [LoehkController::class, 'deleteCommitteeMember'])->name('delete_committee_member');

    Route::post('/event/new', [LoehkController::class, 'newEvent'])->name('new_event');
    Route::post('/event', [LoehkController::class, 'getEvents'])->name('events');
    Route::delete('/event/{event}', [LoehkController::class, 'deleteEvent'])->name('delete_event');
    Route::post('/event/{event}/update', [LoehkController::class, 'updateEvent'])->name('update_event');

    Route::get('/prices', [LoehkController::class, 'getPrices'])->name('prices');
    Route::post('/prices', [ProductController::class, 'newProduct'])->name('newProduct');
    Route::patch('/prices/{product}', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::delete('/prices/{product}', [ProductController::class, 'deleteProduct']);

    Route::get('/streck/print', [StreckController::class, 'print'])->name('streckPrint');

    Route::get('/accounts', [StreckController::class, 'getAccounts']);
    Route::post('/accounts', [StreckController::class, 'newAccount']);
    Route::patch('/accounts/{account}', [StreckController::class, 'updateAccount']);
    Route::delete('/accounts/{account}', [StreckController::class, 'deleteAccount']);
});

Route::get('/counter', [CounterController::class, 'index']);
Route::post('/counter/increase', [CounterController::class, 'increase']);
Route::post('/counter/decrease', [CounterController::class, 'decrease']);
Route::post('/counter/get', [CounterController::class, 'get']);
Route::post('/counter/reset', [CounterController::class, 'reset']);


Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::name('bgg.')->prefix('bgg')->group(static function() {
    Route::post('/search', [BoardGameGeekController::class, 'search'])->name('search');
    Route::post('/fetch/{id}', [BoardGameGeekController::class, 'fetch'])->name('fetch');
});
