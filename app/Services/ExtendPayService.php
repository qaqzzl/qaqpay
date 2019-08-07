<?php
/**
 * 第三方支付业务逻辑
*/
namespace App\Services;
use App\Events\TradePaySuccess;
use App\Models\MerchantTradePay;
use App\Models\OutTradePayLog;
use Illuminate\Support\Facades\DB;
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
            $res = $result->all();

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            //创建第三方支付平台支付回调通知记录
            OutTradePayLog::create([
                'status'=>$res['trade_status'],
                'out_trade_no'=>$res['trade_no'],
                'out_body'=>json_encode($result->all()),
                'created_at'=>time(),
            ]);
            $payok = false;
            if (!empty($res['passback_params'])) {
                $passback_params = json_decode($res['passback_params'],true);
                switch ($passback_params['type']) {
                    case 'openpay':
                        $payok = $this->OpenPayOk($result->out_trade_no, $result->trade_no, $result->total_amount, strtotime($result->gmt_payment));
                        break;
                }
            }
            if ($payok == true) return $alipay->success();
        } catch (\Exception $e) {
            testlog($e->getMessage());
            //return Response::create('error');
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


    /**
     * 开放支付支付成功
     * @param string $trade_no 系统订单号
     * @param string $out_trade_no 第三方交易单号
     * @param string $total_amount 订单金额
     * @param string $out_gmt_payment 第三方支付完成时间
     */
    public function OpenPayOk($trade_no, $out_trade_no, $total_amount, $out_gmt_payment)
    {
        if (!$TradePay = MerchantTradePay::where('trade_no',$trade_no)->first()) {
            return false;
        }

        DB::beginTransaction();    //主事务

        try {
            //更新商户支付表
            $TradePay->out_trade_no = $out_trade_no;
            $TradePay->out_pay_status = 0;
            $TradePay->status = 'wait';     //等待结算
            $TradePay->out_gmt_payment = $out_gmt_payment;     //第三方支付完成时间
            $TradePay->save();

            //支付成功后的事件
            event(new TradePaySuccess($TradePay));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
        }

    }



}