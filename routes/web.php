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

Route::get('/', 'ListsController@index')->name('home');
Route::get('/lists/show/{id}', 'ListsController@show');
Route::post('/lists/create', 'ListsController@create');
Route::post('/lists/archive', 'ListsController@archive');
Route::delete('/lists/{id}', 'ListsController@destroy');

Route::post('/tasks/create', 'TasksController@create');
