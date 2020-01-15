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
	return view('welcome',['date'=>formatDate('2020-01-05')]);
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

    Route::get('/dashboard', 'InvestmentVehiclesController@index')->name('dashboard');

    Route::name('users.')->prefix('users')->group(function(){
    	Route::get('/', 'UsersController@index')->name('index');
        Route::post('/search', 'UsersController@index')->name('search');
    	Route::get('/create', 'UsersController@create')->name('create');
    	Route::post('/', 'UsersController@store')->name('store');
    	Route::get('/{user}/edit', 'UsersController@edit')->name('edit');
    	Route::put('/{user}', 'UsersController@update')->name('update');
    	Route::delete('/{user}', 'UsersController@destroy')->name('destroy');
        Route::get('/{user}/json-fund-managers', 'UsersController@jsonFundManagers')->name('jsonRfms');
    	Route::get('/{user}/json-investors', 'UsersController@jsonInvestors')->name('jsonInvestors');
    });
    Route::name('investment-vehicles.')->prefix('investment-vehicles')->group(function(){
        Route::get('/', 'InvestmentVehiclesController@index')->name('index');
    	Route::post('/search', 'InvestmentVehiclesController@index')->name('search');
    	Route::get('/create', 'InvestmentVehiclesController@create')->name('create');
    	Route::post('/', 'InvestmentVehiclesController@store')->name('store');
    	Route::get('/{investmentVehicle}/edit', 'InvestmentVehiclesController@edit')->name('edit');
    	Route::put('/{investmentVehicle}', 'InvestmentVehiclesController@update')->name('update');
    	Route::delete('/{investmentVehicle}', 'InvestmentVehiclesController@destroy')->name('destroy');
    });
    Route::name('investment-vehicle-returns.')->prefix('investment-vehicle-returns')->group(function(){
        Route::get('/{investmentVehicle}', 'InvestmentVehicleReturnsController@index')->name('index');
        Route::get('/{investmentVehicle}/create', 'InvestmentVehicleReturnsController@create')->name('create');
        Route::post('/{investmentVehicle}/', 'InvestmentVehicleReturnsController@store')->name('store');
        Route::get('/{investmentVehicle}/{investmentVehicleReturn}/edit', 'InvestmentVehicleReturnsController@edit')->name('edit');
        Route::put('/{investmentVehicle}/{investmentVehicleReturn}', 'InvestmentVehicleReturnsController@update')->name('update');
        Route::delete('/{investmentVehicle}/{investmentVehicleReturn}', 'InvestmentVehicleReturnsController@destroy')->name('destroy');
    });
    Route::name('investments.')->prefix('investments')->group(function(){
        Route::get('/', 'InvestmentsController@index')->name('index');
        Route::post('/search', 'InvestmentsController@index')->name('search');
        Route::get('/create', 'InvestmentsController@create')->name('create');
        Route::post('/', 'InvestmentsController@store')->name('store');
        Route::get('/{investment}/edit', 'InvestmentsController@edit')->name('edit');
        Route::put('/{investment}', 'InvestmentsController@update')->name('update');
        Route::delete('/{investment}', 'InvestmentsController@destroy')->name('destroy');
    });
    Route::name('earnings.')->prefix('earnings')->group(function(){
        Route::get('/', 'EarningsController@index')->name('index');
        Route::post('/search', 'EarningsController@index')->name('search');
        Route::get('/{earning}/edit', 'EarningsController@edit')->name('edit');
        Route::put('/{earning}', 'EarningsController@update')->name('update');
        Route::delete('/{earning}', 'EarningsController@destroy')->name('destroy');
    });
});

Route::name('rfm.')->prefix('rfm')->namespace('rfm')->middleware(['auth','checkRole:regional-fund-manager'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::name('fm.')->prefix('fm')->namespace('fm')->middleware(['auth','checkRole:fund-manager'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});


Route::name('investor.')->prefix('investor')->namespace('investor')->middleware(['auth','checkRole:investor'])->group(function () {
    Route::get('/dashboard', 'InvestmentVehiclesController@index')->name('dashboard');
    Route::name('investment-vehicles.')->prefix('investment-vehicles')->group(function(){
        Route::get('/', 'InvestmentVehiclesController@index')->name('index');
    });
    Route::name('investments.')->prefix('investments')->group(function(){
        Route::get('/', 'InvestmentsController@index')->name('index');
    });
    Route::name('earnings.')->prefix('earnings')->group(function(){
        Route::get('/', 'EarningsController@index')->name('index');
    });
    Route::name('my-account.')->prefix('my-account')->group(function(){
        Route::get('/', 'MyAccountController@index')->name('index');
    });
});
