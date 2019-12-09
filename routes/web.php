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



Auth::routes();

Route::middleware(['auth'])->group(function(){

	Route::get('/profile', 'common\ProfileController@edit')->name('common.profile.edit');
	Route::post('/profile', 'common\ProfileController@update')->name('common.profile.update');
	Route::post('/profile/picture', 'common\ProfileController@picture')->name('common.profile.picture');
	Route::get('/change-password', 'common\PasswordController@edit')->name('common.password.edit');
	Route::post('/change-password', 'common\PasswordController@update')->name('common.password.update');

	Route::get('/', function () {
	    if(auth()->user()->isAdmin()) return redirect()->route('admin.dashboard');
	    elseif(auth()->user()->isRegionalFundManager()) return redirect()->route('rfm.dashboard');
	    elseif(auth()->user()->isFundManager()) return redirect()->route('fm.dashboard');
	    elseif(auth()->user()->isInvestor()) return redirect()->route('investor.dashboard');
	    else return redirect()->route('login');

	})->name('dashboard');

	Route::get('/home', function () {
	    return redirect()->route('dashboard');
	})->name('home');

});



Route::name('admin.')->prefix('admin')->namespace('admin')->middleware(['auth','checkRole:admin'])->group(function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::name('users.')->prefix('users')->group(function(){
    	Route::get('/', 'UsersController@index')->name('index');
    	Route::get('/create', 'UsersController@create')->name('create');
    	Route::post('/', 'UsersController@store')->name('store');
    	Route::get('/{user}/edit', 'UsersController@show')->name('show');
    	Route::put('/{$user}', 'UsersController@update')->name('update');
    	Route::delete('/{$user}', 'UsersController@destroy')->name('destroy');
    });
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
