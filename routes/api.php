<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function () {
    return "test";
});

Route::group(['namespace' => 'OpenPay','prefix'=>'openpay'],function() {
    Route::any('notify.alipay', 'PayController@notifyAlipay');         //支付宝回调通知
    Route::any('notify.wechat', 'PayController@notifyWechat');         //微信回调通知
});

Route::group(['namespace' => 'OpenPay','prefix'=>'openpay/v1.0.0'],function(){
    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //创建交易支付

    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //支付宝H5直连支付
    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //微信H5直连支付
});