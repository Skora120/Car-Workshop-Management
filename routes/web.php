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
Route::get('/dashboard/newjoborder', 'DashboardController@jobOrder');
Route::post('/dashboard/newjoborder/new', 'DashboardController@jobOrderPost');
Route::get('/dashboard/newPartOrder', 'DashboardController@partOrder');

//Clients
