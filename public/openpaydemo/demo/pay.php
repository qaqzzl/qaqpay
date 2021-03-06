<?php
require_once '../src/func.php';
require_once '../src/Pay.php';

$domain = 'http://127.0.0.1:82/api/openpay/v1.0.0/';
$api = 'trade.h5.pay';

$account = '201808020100';
$secret_key = 'b111aa37-4a11-45bb-9733-04e37542ff3d';
$param = [
    'account'=>$account,
    'version'=>'1.0.0',
    'trade_no'=>time().mt_rand(100000,999999),
    'total_amount'=>0.1,
    'timestamp'=>time(),
    'client_ip'=>clientip(),
    'choose_pay_type'=>'alipaywap',

    'notify_url'=>'http://tests.ngrok.qaqzz.com/openpaydemo/demo/notify.php',
    'subject'=>'测试创建交易demo',
    'body'=>'测试创建交易demo测试创建交易demo测试创建交易demo',
    'timeout_express'=>'90m',                                                     //交易关闭时间
    'passback_params'=>'{"type":"ABC","rand":"123456","content":"测试一下呀"}',   //自定义数据 , 回调通知时原样返回
];

$pay = new \QaqPay\Pay();

$param['sign'] = $pay->generateSign($param,$secret_key);

$result = curl($domain.$api,'POST',$param);
$res = json_decode($result);
if ($res->code == 0) {
    print_r($res->data->content);
} else {
    print_r($res->msg);
}

