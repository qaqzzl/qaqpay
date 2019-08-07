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