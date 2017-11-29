<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('login', 'Index@login');

// Route::group(['middleware' => 'auth'], function () {
    Route::any('/', 'Index@index');
    Route::any('api/cate', 'Index@cate');
    Route::any('api/add', 'Index@add');
    Route::any('api/list', 'Index@getList');
    Route::any('api/report', 'Index@getReport');
    Route::any('api/chart', 'Index@chart');
    Route::any('report', 'Index@report');
// });