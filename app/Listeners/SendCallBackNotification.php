<?php

namespace App\Listeners;
//发送商户支付回调通知
use App\Events\TradePaySuccess;
use App\Models\MerchantTradeNotify;
use App\Services\OpenPayService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Http\Message\ResponseInterface;

class SendCallBackNotification
{

    public $openPayService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->openPayService =  new OpenPayService;
    }

    /**
     * Handle the event.
     *
     * @param  TradePaySuccess  $event
     * @return void
     */
    public function handle(TradePaySuccess $event)
    {
        $openPayService = $this->openPayService;
        $time = time();
        $TradePay = $event->MerchantTradePay;
        if (empty($TradePay->notify_url)) return false;

        if (MerchantTradeNotify::where('out_trade_no',$TradePay->out_trade_no)->count())  return false;

        $notice_body = [
            'trade_no'=>$TradePay->trade_no,    //系统交易号
            'total_amount'=>$TradePay->total_amount,
            'out_trade_no'=>$TradePay->merchant_trade_no,    //商户交易订单号
            'version'=>'1.0.0',
            'passback_params'=>$TradePay->passback_params,
            'gmt_create'=>$TradePay->created_at,    //系统交易创建时间
            'gmt_payment'=>$TradePay->out_gmt_payment,  //第三方支付成功时间
            'notify_time'=>$time,
        ];

        $notice_body['sign'] = $openPayService->generateSign($notice_body, $TradePay->merchant->secret_key);

        //创建回调信息
        $notice = [
            'merchant_id'=>$TradePay->merchant_id,
            'status'=>'wait',
            'frequency'=>1,
            'last_notice_time'=>$time,
            'out_trade_no'=>$TradePay->out_trade_no,
            'notify_url'=>$TradePay->notify_url,
            'notice_body'=>json_encode($notice_body),
        ];
        MerchantTradeNotify::create($notice);

        $client = new Client();
        $options['body'] = $notice_body;
        $promise = $client->requestAsync('POST', $TradePay->notify_url, $options);
        $promise->then(
            function (ResponseInterface $res) use ($TradePay) {
                if ($res->getBody() == 'success') {
                    $TradePay->status = 'success';
                    $TradePay->save();
                }

            },
            function (RequestException $e) {

            }
        );
    }
}
