<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout',function(){
    Auth::logout();
    return redirect("/");
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'personal'], function () {
    Route::get('show', [ 'as' => 'show', 'uses' => 'PersonalController@showPersonal'  ] );
    Route::get('all/page{page?}_{count?}/sort{field?}_{order?}/search{text?}', [ 'as' => 'get_data', 'uses' => 'PersonalController@getAllDataByPages'  ] )
        ->where(['page' => '[0-9]+', 'count' => '[0-9]+','field'=>'[a-zA-Z]+','order'=>'[a-z]{3,4}']);
    Route::get('showTree', [ 'as' => 'show', 'uses' => 'PersonalController@showPersonalTree'  ] );
    Route::get('getOne/{id}', [ 'as' => 'get', 'uses' => 'PersonalController@getOne'  ] )
        ->where(['id' => '[0-9]+']);
    Route::get('del/{id}', [ 'as' => 'del', 'uses' => 'PersonalController@delPersonal'  ] );
    Route::post('update', [ 'as' => 'update', 'uses' => 'PersonalController@updatePersonal'  ] );
    Route::post('add', [ 'as' => 'add', 'uses' => 'PersonalController@addPersonal'  ] );
    Route::get('getTree', [ 'as' => 'get', 'uses' => 'PersonalController@getTree'  ] );
    Route::get('getTree/{id?}', [ 'as' => 'get', 'uses' => 'PersonalController@getTreeNode'  ] );
});