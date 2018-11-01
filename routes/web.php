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

Route::get('/', function () {
    return view('index');
});

//api
route::prefix('/api/')->group(function () {

    Route::get('test', 'IndexController@test');

    route::prefix('system/')->namespace('System')->group(function () {
        Route::get('group/list', 'GroupController@getList');
    });

});


