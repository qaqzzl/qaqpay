<?php
require_once './src/func.php';
require_once './src/Pay.php';

$domain = 'http://127.0.0.1:82/api/openpay/v1.0.0/';
$api = 'trade.h5.pay';

$secret_key = 'b111aa37-4a11-45bb-9733-04e37542ff3d';
$param = [
    'account'=>'201808020100',
    'version'=>'1.0.0',
    'trade_no'=>time().mt_rand(100000,999999),
    'total_amount'=>0.01,
    'timestamp'=>time(),
    'client_ip'=>clientip(),
    'choose_pay_type'=>'alipaywap',

    'subject'=>'测试demo',
    'body'=>'测试demo',
    'timeout_express'=>'90m',
    'passback_params'=>'自定义数据 , 回调通知时原样返回',
];

$pay = new \QaqPay\pay();

$param['sign'] = $pay->generateSign($param,$secret_key);

$res = curl($domain.$api,'POST',$param);

print_r($res);

