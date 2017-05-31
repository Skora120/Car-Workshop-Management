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

//Workshop public page
//Route::get('/', 'PublicSiteController@index');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('installer')->group(function(){
	Route::get('/', 'InstallerController@show');
	Route::put('/update', 'InstallerController@update')->name('envUpdate');
});

Auth::routes();

//Employee Login
Route::get('/employee', 'Auth\EmployeeLoginController@showLoginForm')->name('employee-login');
Route::post('/employee/login', 'Auth\EmployeeLoginController@login')->name('employee-login.submit');

//Dashboard
Route::prefix('dashboard-employee')->group(function(){
	//Employees routes
	Route::get('/', 'DashboardEmployeeController@index')->name('dashboard-employee');
	Route::get('/advanced', 'DashboardEmployeeController@showAdvanced')->name('dashboard-advanced');

	Route::get('/history', 'HistoryController@index')->name('history');

	Route::get('/settings', 'DashboardEmployeeController@settings');
	Route::put('/settings/password/put', 'DashboardEmployeeController@settingsPasswordSave');
	Route::put('/settings/phone/put', 'DashboardEmployeeController@settingsPhoneSave');

	Route::get('/search', 'SearchEngineController@search')->name('search');
	Route::get('/search/partAjax', 'SearchEngineController@searchPartAjax')->name('searchPartAjax');
	Route::get('/search/part/{str}', 'SearchEngineController@searchPart')->name('searchPart');
	Route::get('/search/clientAjax', 'SearchEngineController@searchClientAjax')->name('searchClientAjax');
	Route::get('/search/client/{str}', 'SearchEngineController@searchClient')->name('searchClient');
	Route::get('/search/{id}', 'SearchEngineController@searchSideBar');


	Route::prefix('clients')->group(function(){
		Route::get('/newclient', 'ClientController@newClient')->name('createClient');
		Route::get('/client/searchAjax', 'ClientController@searchAjax')->name('clientSearchAjax');
		Route::get('/client/carsAjax', 'ClientController@carsAjax')->name('clientCarsAjax');
		Route::post('/newClientAjax', 'ClientController@newClientAjax')->name('createClientAjax');
		Route::post('/newclient/post', 'ClientController@newClientPost')->name('createClientPost');
		Route::put('/{id}/clientedit', 'ClientController@clientEdit');
		Route::delete('/{id}/clientdel', 'ClientController@clientDelete');
		Route::post('/{id}/caradd', 'CarsController@carAdd');
		Route::get('/{id}', 'ClientController@indexDescription')->name('client');
		Route::get('/', 'ClientController@index')->name('clients');
	});

	Route::prefix('employees')->group(function(){
		Route::get('/', 'EmployeesController@index')->name('employees');
		Route::post('/post', 'EmployeesController@employeeAdd');
		Route::put('/{id}/put', 'EmployeesController@employeeEdit');
		Route::delete('/{id}/delete', 'EmployeesController@employeeDelete');
		Route::get('/{id}', 'EmployeesController@indexDescription')->name('employee');

	});

	Route::prefix('cars')->group(function(){
		Route::delete('/{id}/edit/delete', 'CarsController@carDelete');
		Route::put('/{id}/edit/put', 'CarsController@carEditPut');
		Route::get('/{id}/edit', 'CarsController@carEdit');
		Route::get('/{id}', 'CarsController@indexDescription');
		Route::get('/', 'CarsController@index')->name('cars');
	});

	Route::prefix('jobs')->group(function(){
		Route::get('/newjob', 'JobsController@createJob')->name('createJob');
		Route::post('/newjob', 'JobsController@createJobAjax')->name('createJobAjax');
		Route::post('/{id}/detailAdd', 'JobsController@DetAdd');
		Route::get('/{id}/edit', 'JobsController@indexDescEdit');
		Route::put('/{id}/edit/put', 'JobsController@OrderEditPut');
		Route::delete('/{id}/edit/delete', 'JobsController@OrderDelete');
		Route::put('/{id}/edit/detailEdit', 'JobsController@DetEditPut');
		Route::delete('/{id}/edit/detailDelete', 'JobsController@DetDelete');
		Route::get('/{id}', 'JobsController@indexDescription')->name('job');
		Route::get('/', 'JobsController@index')->name('jobs');
	});

	//Parts
	Route::prefix('parts')->group(function(){
		Route::get('/{id}', 'PartsController@indexDescription')->name('part');
		Route::post('/post', 'PartsController@addPart')->name('part-post');
		Route::put('/{id}/put', 'PartsController@editPart')->name('part-edit');
		Route::delete('/{id}/delete', 'PartsController@deletePart')->name('part-delete');
		Route::get('/', 'PartsController@index')->name('parts');

	});	
});

Route::prefix('dashboard')->group(function(){
	//Clients routes
	Route::get('/', 'DashboardClientController@index')->name('dashboard');
	Route::get('/history', 'DashboardClientController@clientOrders')->name('clientViewOrders');
	Route::get('/settings', 'DashboardClientController@settings')->name('clientSettings');
	Route::put('/settings/put', 'DashboardClientController@settingsSave')->name('clientSettingsPut');

});