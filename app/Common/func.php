<?php

function api_success($data = [], $code=0, $msg = '')
{
    if (empty($data)) $data = (object)[];
    if ($msg == '') {
        $msg = config('openPayStatusCode')[$code];
    }
    $json = [
        'code'=>$code,
        'data'=>$data,
        'msg'=>$msg
    ];
    return response()->json($json);
}
function api_error($code = 5000, $data = [], $msg = '')
{
    if (empty($data)) $data = (object)[];
    if ($msg == '') {
        $msg = config('openPayStatusCode')[$code];
    }
    $json = [
        'code'=>$code,
        'data'=>$data,
        'msg'=>$msg
    ];
    return response()->json($json);
}


function testlog($str)
{
    $logFile = fopen(
        storage_path('logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_app.log'),
        'a+'
    );
    fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $str . "\r\n");
    fclose($logFile);
}