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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//购物车
Route::get('/cart/add/{goods_id?}', 'CartController@add');      //添加至购物车
Route::get('/cart', 'CartController@index');
Route::get('/detail/{goods_id?}', 'GoodsDetailController@detail');      //添加至购物车
//订单处理
Route::get('/order/list', 'Order\IndexController@List');      //订单列表
Route::get('/order/create', 'Order\IndexController@create');      //生成订单
Route::get('/order/payStatus', 'Order\IndexController@payStatus');      //查询订单支付状态
//微信支付
Route::get('/pay/weixin', 'Weixin\PayController@pay');      //微信支付
Route::post('/weixin/pay/notify', 'Weixin\PayController@notify');      //微信支付通知回调
//支付
Route::get('/pay/success', 'Weixin\PayController@paySuccess');      //微信支付成功
//redis 缓存
Route::get('/detail/{goods_id?}', 'GoodsDetailController@detail');      //浏览数量
Route::get('/getscore', 'GoodsDetailController@getscore');
//计划任务
Route::get('/weixin/delorder','Contab\ContabController@del_order');//删除过期订单

//微信接口返回文件
Route::get('/weixin/list','Wx\WeiXinController@list');
Route::post('/weixin/list','Wx\WeiXinController@wxEvent');
