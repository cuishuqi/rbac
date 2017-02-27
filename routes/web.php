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
    return view('welcome');
});
Route::group(['namespace' =>'Admin','prefix'=>'admin'],function(){

        Route::post('login','LoginController@login');
        Route::any('logout','LoginController@logout');
        Route::get('index',function(){
            return view('admin.index.index');
        });
        Route::get('permission/index/{cid?}',['as'=>'admin.permission.index','uses'=>'PermissionController@index']);
        Route::get('permission/create/{cid?}',['as'=>'admin.permission.create','uses'=>'PermissionController@create']);
        Route::post('permission/store',['as'=>'admin.permission.store','uses'=>'PermissionController@store']);
        Route::get('permission/{pid}/edit',['as'=>'admin.permission.edit','uses'=>'PermissionController@edit']);
        Route::get('permission/delete/{pid}',['as'=>'admin.permission.delete','uses'=>'PermissionController@delete']);
        Route::get('role/index',['as'=>'admin.role.index','uses'=>'RoleController@index']);
    }
);




Route::get('admin/login','Admin\LoginController@showLogin');