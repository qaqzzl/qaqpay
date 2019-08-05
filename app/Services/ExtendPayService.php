<?php
/**
 * 第三方支付业务逻辑
*/
namespace App\Services;
use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
class ExtendPayService {


    /**
     * 支付宝回调通知
    */
    public function NotifyAlipay()
    {
        $alipay = Pay::alipay(config('pay.alipay'));

        try{
            $result = $alipay->verify();
            Log::debug('Aliyun notify', $result->all());
            Log::debug('Aliyun passback_params', $result->get('passback_params'));
            $res = $result->all();
            if (!empty($res['passback_params'])) {
                $passback_params = json_decode($res['passback_params']);
                switch ($passback_params['type']) {
                    case 'openpay':

                        break;
                }
            }

            return $alipay->success();
        } catch (\Exception $e) {
            // $e->getMessage();
            return Response::create('error');
        }
    }

    /**
     * 微信回调通知
    */
    public function notifyWechat()
    {
        $wechat = Pay::wechat($this->config);

        try{
            $data = $wechat->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $wechat;
    }



}