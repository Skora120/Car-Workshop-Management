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

//Workshop public page//
Route::get('/', 'PublicSiteController@index');

Auth::routes();

//Dashboard
Route::get('/dashboard', 'DashboardController@index');

//Employees
//Jobs
Route::get('/dashboard/jobs', 'JobsController@index');
Route::get('/dashboard/newjoborder', 'JobsController@jobOrder');
Route::post('/dashboard/newjoborder/new', 'JobsController@jobOrderPost');
//Clients
Route::get('/dashboard/newclient', 'ClientController@client');
Route::post('/dashboard/newclient/new', 'ClientController@newclient');
//Parts
Route::get('/dashboard/newPartOrder', 'DashboardController@partOrder');

//Clients
