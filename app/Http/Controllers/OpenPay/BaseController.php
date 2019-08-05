<?php

namespace App\Http\Controllers\OpenPay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class BaseController extends Controller
{
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []){
        $Validator = Validator::make($request->all(),$rules,$messages);
        if($Validator->fails()){
            foreach ($Validator->errors()->messages() as $key=>$vo) {
                $errmsg = $key . ' ' . $vo[0];
                break;
            }
            $response = api_error(4000,[],$errmsg);
            $response->sendHeaders();
            echo $response->content();
            exit;
        }
        return $Validator;
    }

}

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