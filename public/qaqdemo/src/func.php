<?php

function curl($url,$type='GET',$data=[])
{
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    //HTTPS
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    //设置为0、1控制是否返回请求头信息
    curl_setopt($curl, CURLOPT_HEADER, 0);

    //是否返回主体内容 body
//        curl_setopt($curl, CURLOPT_NOBODY, true);

    if ($type == 'POST') {
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    $return_str = curl_exec($curl);
    curl_close($curl);
    return $return_str;
}

function clientip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //ip是否来自共享互联网
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //ip是否来自代理
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {        //ip是否来自远程地址
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}