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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/','HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@index');
    Route::resource('article', 'ArticleController');
});
//Route::resource('photo','PhotoController');
Route::get('article/{id}','ArticleController@show');
Route::post('comment', 'CommentController@store');
Route::get('ins','InsController@index');
Route::get('/ins/create','InsController@create');
Route::post('/ins/save','InsController@save');
Route::get('/ins/detail/{id}','InsController@detail');
Route::get('/ins/tags/{tag}/{id}','InsController@tag');
Route::get('/ins/tags','InsController@tags');//所有标签
Route::get('/user/{id}','UserController@index');