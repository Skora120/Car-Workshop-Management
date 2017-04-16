
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
		Route::prefix('clients')->group(function(){
		Route::get('/newclient', 'ClientController@newClient')->name('createClient');
		Route::post('/newclient/post', 'ClientController@newClientPost')->name('createClientPost');
		Route::put('/id/{id}/clientedit', 'ClientController@clientEdit');
		Route::delete('/id/{id}/clientdel', 'ClientController@clientDelete');
		Route::get('/id/{id}', 'ClientController@indexDescription');
		Route::get('/', 'ClientController@index')->name('clients');
	});

	Route::prefix('jobs')->group(function(){
		Route::get('/newjob', 'JobsController@createJob')->name('createJob');
		Route::post('/newjob/post', 'JobsController@createJobPost');
		Route::post('/{id}/detailAdd', 'JobsController@DetAdd');
		Route::get('/{id}/edit', 'JobsController@indexDescEdit');
		Route::put('/{id}/edit/put', 'JobsController@OrderEditPut');
		Route::delete('/{id}/edit/delete', 'JobsController@OrderDelete');
		Route::put('/{id}/edit/detailEdit', 'JobsController@DetEditPut');
		Route::delete('/{id}/edit/detailDelete', 'JobsController@DetDelete');
		Route::get('/{id}', 'JobsController@indexDescription');
		Route::get('/', 'JobsController@index')->name('jobs');
	});

	//Parts
	Route::prefix('parts')->group(function(){
		Route::post('/post', 'PartsController@addPart')->name('part-post');
		Route::put('/put', 'PartsController@editPart')->name('part-edit');
		Route::delete('/delete', 'PartsController@deletePart')->name('part-delete');
		Route::get('/', 'PartsController@index')->name('jobs');
	});
});

Route::prefix('dashboard')->group(function(){
	//Clients routes
	Route::get('/', 'DashboardClientController@index')->name('dashboard');
});