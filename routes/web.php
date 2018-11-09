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
Route::prefix('/api/')->group(function () {

    Route::get('test', 'IndexController@test');

    route::namespace('Auth')->group(function () {
        Route::post('login', 'loginController@login');
        Route::post('logout', 'loginController@logout');
    });


    /**
     * 系统设置
     */
    route::prefix('system/')->namespace('System')->group(function () {
        //管理组管理
        Route::get('group/list', 'GroupController@getList');
        Route::post('group/save', 'GroupController@save');

        //权限管理
        Route::get('rule/list', 'RuleController@getTreeList');
        Route::get('rule/routes', 'RuleController@getAllRoutes');
        Route::post('rule/save', 'RuleController@save');
        Route::get('rule/get', 'RuleController@get');

        //用户管理
        Route::get('admin/list', 'AdminController@getList');
        Route::get('admin/loglist', 'AdminController@getLogs');
        Route::post('admin/save', 'AdminController@save');
        Route::post('admin/avatar/upload', 'AdminController@uploadAvatar');
        Route::post('admin/avatar/save', 'AdminController@saveAvatar');
        Route::get('admin/profile/get', 'AdminController@getProfile');
        Route::post('admin/password/change', 'AdminController@changePassword');
    });

});


