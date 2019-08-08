<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('statistics', 'HomeController@statistics')->name('admin.home.statistics');

    $router->resource('merchants', MerchantController::class);

    $router->resource('merchant-trade-bills', MerchantTradeBillsController::class);

    $router->resource('merchant-trade-pays', MerchantTradePayController::class);

    $router->resource('merchant-amount-withdraws', MerchantAmountWithdrawController::class);    //提现管理
});
