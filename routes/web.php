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
Route::get('/', 'PublicSiteController@index');

Auth::routes();

//Employee Login
Route::get('/employee', 'Auth\EmployeeLoginController@showLoginForm')->name('employee-login');
Route::post('/employee/login', 'Auth\EmployeeLoginController@login')->name('employee-login.submit');

//Dashboard
Route::prefix('dashboard-employee')->group(function(){
	//Employees routes
	Route::get('/', 'DashboardEmployeeController@index')->name('dashboard-employee');

	Route::get('/clients/newclient', 'ClientController@newClient')->name('createClient');
	Route::post('/clients/newclient/post', 'ClientController@newClientPost')->name('createClientPost');
	Route::get('/clients', 'ClientController@index')->name('clients');
	Route::get('/clients/id/{id}', 'ClientController@indexDescription');

	Route::get('/jobs/newjob', 'JobsController@createJob')->name('createJob');
	Route::post('/jobs/newjob/post', 'JobsController@createJobPost');
	Route::post('/jobs/{id}/detailAdd', 'JobsController@DetAdd');
	Route::get('/jobs/{id}/edit', 'JobsController@indexDescEdit');
	Route::put('/jobs/{id}/edit/put', 'JobsController@OrderEditPut');
	Route::delete('/jobs/{id}/edit/delete', 'JobsController@OrderDelete');
	Route::put('/jobs/{id}/edit/detailEdit', 'JobsController@DetEditPut');
	Route::delete('/jobs/{id}/edit/detailDelete', 'JobsController@DetDelete');
	Route::get('/jobs/{id}', 'JobsController@indexDescription')->name('jobs');

	Route::get('/jobs', 'JobsController@index')->name('jobs');

	//Parts
});

Route::prefix('dashboard')->group(function(){
	//Clients routes
	Route::get('/', 'DashboardClientController@index')->name('dashboard');
});