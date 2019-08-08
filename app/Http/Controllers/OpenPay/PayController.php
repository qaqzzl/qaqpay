<?php

namespace App\Http\Controllers\OpenPay;

use App\Models\Merchant;
use App\Models\MerchantTradeNotify;
use App\Models\MerchantTradePay;
use App\Services\ExtendPayService;
use App\Services\OpenPayService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class PayController extends BaseController
{
    public function test()
    {
        $this->notify_test();
    }

    //回调通知测试
    public function notify_test()
    {
        $notify = MerchantTradeNotify::where('status','wait')->get();
        $client = new Client();
        foreach ($notify as $vo) {
            $options['form_params'] = json_decode($vo->notice_body,true);
            $promise = $client->requestAsync('POST', $vo->notify_url,$options);
            $promise->then(
                function (ResponseInterface $res) use ($vo) {
                    testlog("异步请求返回值: ".json_encode($res));
                    dump($res->getBody()->getContents());
                },
                function (RequestException $e) {
                    dump('请求失败');
                }
            )->wait();
        }
        dd($notify);
    }

    //交易支付
    public function tradeH5Pay(Request $request, OpenPayService $openPayService)
    {
        $data = $this->validate($request,[
            'account'=>'required',
            'version'=>'required',
            'trade_no'=>'required',
            'total_amount'=>'required',
            'timestamp'=>'required',
            'client_ip'=>'required',
            'choose_pay_type'=>'required',
            'subject'=>'required',
            'sign'=>'required',
        ]);
        try {
            if (!$merchant = Merchant::where('account',$request->account)->first()) {
                return api_error(4001);
            }
            if ($merchant->secret_key != $request->secret_key) api_error(4001);
            //验签
            $openPayService->verifySign($request->all(), $merchant->secret_key);

            //创建交易
            $payinfo = $openPayService->CreateTrade($request->all(), $merchant->merchant_id);
            return api_success(['content'=>$payinfo->getContent()]);
            //return view('qaqpay.h5',['choose_pay_type'=>$request->choose_pay_type,'total_amount'=>$request->total_amount,'payinfo'=>[] ]);
        } catch (\Exception $exception) {
            return api_error($exception->getCode(),[],$exception->getMessage());
        }
    }

    //直连支付


    //支付宝支付回调
    public function notifyAlipay(ExtendPayService $extendPayService)
    {
        return $extendPayService->NotifyAlipay();
    }

    //微信支付回调
    public function notifyWechat(ExtendPayService $extendPayService)
    {
        $extendPayService->notifyWechat();
    }
}