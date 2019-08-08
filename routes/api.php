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
    Route::any('test', 'PayController@test');             //test


    Route::any('notify.alipay', 'PayController@notifyAlipay');         //支付宝回调通知
    Route::any('notify.wechat', 'PayController@notifyWechat');         //微信回调通知

});

Route::group([
    'namespace' => 'OpenPay',
    'prefix'=>'openpay/v1.0.0'
],function() {
    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //创建交易支付
    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //支付宝H5直连支付
    Route::any('trade.h5.pay', 'PayController@tradeH5Pay');             //微信H5直连支付

    //商户接口
    Route::any('login.signin', 'MerchantController@signin');             //商户登录
    Route::group([
        'middleware' => 'auth.merchant.login',
    ],function() {
        Route::any('trade.statistics', 'MerchantController@tradeStatistics');             //交易统计
        Route::any('trade.bills.list', 'MerchantController@tradeBillsList');             //商户交易流水列表
        Route::any('trade.withdraw.list', 'MerchantController@tradeWithdrawList');             //商户提现申请列表
        Route::any('trade.withdraw.application', 'MerchantController@tradeWithdrawApplication');             //商户提现申请
    });
});