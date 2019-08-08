<?php
require_once '../src/func.php';
require_once '../src/Pay.php';
$secret_key = 'b111aa37-4a11-45bb-9733-04e37542ff3d';
$request = $_POST;
applog(json_encode($request));

//验证签名
$sign = $request['sign'];
unset($request['sign']);
$pay = new \QaqPay\Pay();

$generateSing = $pay->generateSign($request,$secret_key);

if ($sign == $generateSing) {
    //成功处理返回
    exit("success");
}
exit('签名错误');


