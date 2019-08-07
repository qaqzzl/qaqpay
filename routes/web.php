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
    Route::any('/', 'MerchantAdminPage@login');                      //商户后台登录
});

Route::group([
    'namespace' => 'OpenPay',
    'middleware' => 'auth.merchant.login'
],function() {
    Route::any('index', 'MerchantAdminPage@index');                  //商户后台首页
    Route::any('dashboard', 'MerchantAdminPage@dashboard');          //控制面板
    Route::any('trade-bills', 'MerchantAdminPage@trade_bills');          //交流流水
    Route::any('trade-withdraw', 'MerchantAdminPage@trade_withdraw');          //提现申请列表
    Route::any('trade-withdraw-application', 'MerchantAdminPage@trade_withdraw_application');          //提现申请


});