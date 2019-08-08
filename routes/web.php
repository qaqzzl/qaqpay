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

//Route::get('/', function () {
//    return view('welcome');
//});



#商户后台页面
Route::group(['namespace' => 'OpenPay'],function() {
    Route::get('/', 'MerchantAdminPage@login');                      //商户后台登录
});

Route::group([
    'namespace' => 'OpenPay',
    'middleware' => 'auth.merchant.login'
],function() {
    Route::get('merchant-edit', 'MerchantAdminPage@merchant_edit');                  //修改商户资料
    Route::get('index', 'MerchantAdminPage@index');                  //商户后台首页
    Route::get('dashboard', 'MerchantAdminPage@dashboard');          //控制面板
    Route::get('trade-bills', 'MerchantAdminPage@trade_bills');          //交流流水
    Route::get('trade-withdraw', 'MerchantAdminPage@trade_withdraw');          //提现申请列表
    Route::get('trade-withdraw-application', 'MerchantAdminPage@trade_withdraw_application');          //提现申请


});