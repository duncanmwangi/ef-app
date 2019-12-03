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

Route::get('/', function () {
    if(auth()->user()->isAdmin()) return redirect()->route('admin.dashboard');
    elseif(auth()->user()->isRegionalFundManager()) return redirect()->route('rfm.dashboard');
    elseif(auth()->user()->isFundManager()) return redirect()->route('fm.dashboard');
    elseif(auth()->user()->isInvestor()) return redirect()->route('investor.dashboard');
    else return redirect()->route('login');

})->middleware(['auth'])->name('dashboard');

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('home');

Auth::routes();

Route::name('admin.')->prefix('admin')->namespace('admin')->middleware(['auth','checkRole:admin'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::name('rfm.')->prefix('rfm')->namespace('rfm')->middleware(['auth','checkRole:regional-fund-manager'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::name('fm.')->prefix('fm')->namespace('fm')->middleware(['auth','checkRole:fund-manager'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::name('investor.')->prefix('investor')->namespace('investor')->middleware(['auth','checkRole:investor'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});
