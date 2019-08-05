<?php

namespace App\Http\Controllers\OpenPay;

use App\Models\Merchant;
use App\Services\ExtendPayService;
use App\Services\OpenPayService;
use Illuminate\Http\Request;
class PayController extends BaseController
{
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

//        try {
            if (!$merchant = Merchant::where('account',$request->account)->first()) {
                return api_error(4001);
            }
            if ($merchant->secret_key != $request->secret_key) api_error(4001);
            //验签
            $openPayService->verifySign($request->all(), $merchant->secret_key);

            //创建交易
            $payinfo = $openPayService->CreateTrade($request->all(), $merchant->merchant_id);
            return $payinfo;
//            return view('qaqpay.h5',['choose_pay_type'=>$request->choose_pay_type,'total_amount'=>$request->total_amount,'payinfo'=>[] ]);
//        } catch (\Exception $exception) {
//            return api_error($exception->getCode(),[],$exception->getMessage());
//        }
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
