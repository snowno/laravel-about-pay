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
    Route::get('pay','PayController@order');
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
Route::get('wechat','PayController@wechat');
Route::get('/pay/wxreturn/{$orderNum}','PayController@wxreturn');//暂刷完跳转
Route::post('wxresult','PayController@wxresult');
//Route::post('/pay/orderstatus','PayController@orderstatus');
Route::get('wxrefund','PayController@wxrefund');
Route::post('wxrefunded','PayController@wxrefunded');
Route::get('wxrefundreturn','PayController@wxrefundreturn');

//支付宝提现（转账）接口 test
Route::get('alitranspay','PayController@alitranspay');
Route::post('alipayment','PayController@alipayment');
//异步回调结果
Route::post('transpayNotify','PayController@transpayNotify');

//微信商户向用户付款
Route::get('wxtranspay','PayController@wxtranspay');

//支付宝支付

Route::get('alipay','PayController@alipay');
Route::get('alipayReturn','PayController@alipayReturn');
Route::get('alipayRefund','PayController@alipayRefund');
Route::any('alipayRefunded','PayController@alipayRefunded');
Route::get('wechatPay','PayController@wechatPay');
Route::any('wepayReturn','PayController@wepayReturn');
Route::get('wechatRefund','PayController@wechatRefund');

Route::post('orderquery','PayController@orderquery');
Route::get('wepayResult','PayController@wepayResult');
Route::get('test','TestController@index');
Route::get('open','PayController@queryOpenIdByUserId');
Route::get('wechatCloseOrder/{id}','PayController@wechatCloseOrder');


//test
Route::get('cons','TestController@cons');
Route::get('test','TestController@test');