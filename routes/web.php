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

Route::get('test',function(){
	dd(
		App\InvestmentVehicle::where('status','active')
		->get()
		->random()
	);
});

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
    	Route::get('/{user}/edit', 'UsersController@edit')->name('edit');
    	Route::put('/{user}', 'UsersController@update')->name('update');
    	Route::delete('/{user}', 'UsersController@destroy')->name('destroy');
    	Route::get('/{user}/json-fund-managers', 'UsersController@jsonFundManagers')->name('jsonRfms');
    });
    Route::name('investment-vehicles.')->prefix('investment-vehicles')->group(function(){
    	Route::get('/', 'InvestmentVehicleController@index')->name('index');
    	Route::get('/create', 'InvestmentVehicleController@create')->name('create');
    	Route::post('/', 'InvestmentVehicleController@store')->name('store');
    	Route::get('/{investmentVehicle}/edit', 'InvestmentVehicleController@edit')->name('edit');
    	Route::put('/{investmentVehicle}', 'InvestmentVehicleController@update')->name('update');
    	Route::delete('/{investmentVehicle}', 'InvestmentVehicleController@destroy')->name('destroy');
    });
    Route::name('investment-vehicle-returns.')->prefix('investment-vehicle-returns')->group(function(){
        Route::get('/{investmentVehicle}', 'InvestmentVehicleReturnsController@index')->name('index');
        Route::get('/{investmentVehicle}/create', 'InvestmentVehicleReturnsController@create')->name('create');
        Route::post('/{investmentVehicle}/', 'InvestmentVehicleReturnsController@store')->name('store');
        Route::get('/{investmentVehicle}/{investment}/edit', 'InvestmentVehicleReturnsController@edit')->name('edit');
        Route::put('/{investmentVehicle}/{investment}', 'InvestmentVehicleReturnsController@update')->name('update');
        Route::delete('/{investmentVehicle}/{investment}', 'InvestmentVehicleReturnsController@destroy')->name('destroy');
    });
    Route::name('investments.')->prefix('investments')->group(function(){
        Route::get('/', 'InvestmentController@index')->name('index');
        Route::get('/create', 'InvestmentController@create')->name('create');
        Route::post('/', 'InvestmentController@store')->name('store');
        Route::get('/{investment}/edit', 'InvestmentController@edit')->name('edit');
        Route::put('/{investment}', 'InvestmentController@update')->name('update');
        Route::delete('/{investment}', 'InvestmentController@destroy')->name('destroy');
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
