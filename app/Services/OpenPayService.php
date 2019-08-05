<?php
/**
 * QAQ支付系统开放接口
*/
namespace App\Services;
use App\Models\MerchantTradePay;
use function App\Http\Controllers\OpenPay\api_error;
use App\Models\Merchant;
use Faker\Provider\Payment;
use Ramsey\Uuid\Uuid;
use Yansongda\Pay\Pay;

class OpenPayService
{

    public $Charset = 'utf-8';

    private $secret_key = '';

    /**
     * 创建交易
    */
    public function CreateTrade($param,$merchant_id)
    {
        if (! $trade_pay = MerchantTradePay::where('merchant_trade_no',$param['trade_no'])->where('merchant_id',$merchant_id)->first() ) {
            $create = [
                'merchant_id'=>$merchant_id,
                'trade_no'=>time().mt_rand(1000000,9999999),
                'out_pay_status'=>1,
                'merchant_trade_no'=>$param['trade_no'],
                'total_amount'=>$param['total_amount'],
                'subject'=>empty($param['subject'])?'':$param['subject'],
                'body'=>empty($param['body'])?'':$param['body'],
                'timeout_express'=>empty($param['timeout_express'])?'':$param['timeout_express'],
                'passback_params'=>empty($param['passback_params'])?'':$param['passback_params'],
                'choose_pay_type'=>$param['choose_pay_type'],

            ];
            if (! $trade_pay =  MerchantTradePay::create($create) ) {
                return api_error(5000);
            }
        }
        if ($trade_pay->out_pay_status != 1) return api_error(10001);

        $passback_params = json_encode(['type'=>'openpay']);

        switch ($param['choose_pay_type']) {
            case 'alipaywap':   //手机网站支付
                $order = [
                    'out_trade_no' => $trade_pay->trade_no,
                    'total_amount' => $trade_pay->total_amount,
                    'subject' => $trade_pay->subject,
                    'passback_params'=>$passback_params,
                ];
                return Pay::alipay(config('pay.alipay'))->wap($order);

                break;
            case 'wechath5':    //h5支付
                $order = [
                    'out_trade_no' => $trade_pay->trade_no,
                    'body' =>  $trade_pay->subject,
                    'total_fee' => $trade_pay->total_amount * 100,
                ];
                return Pay::wechat(config('pay.wechat'))->scan($order);
                break;
        }

    }

    /**
     * 直连支付
    */


    /**
     * 通知商户回调
    */

    /**
     * 第三方支付成功回调业务
     */
    public function ExtendPayOk()
    {
        
    }




        /***********************************openpay 公共方法***************************************/

    /**
     * 验证签名
    */
    public function verifySign($param,$secret_key)
    {
        $sign = $param['sign'];
        # 去除secret_key
//        unset($param['secret_key']);
        unset($param['sign']);

        if ($this->generateSign($param,$secret_key) !== $sign) {
             throw new \Exception('签名错误',4002);
        }
        return true;
    }

    /**
     * 生成签名
    */
    public function generateSign($param, $secret_key)
    {
        # 排序并进行url编码
        $urlparam = $this->getUrlParam($param);
        $sign = md5($urlparam.$secret_key);
        return $sign;
    }


    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value)) return true;
        if ($value === null) return true;
        if (trim($value) === "") return true;

        return false;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {

        if (!empty($data)) {
            $fileType = $this->Charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }


    /**
     * 做数组排序并进行urlparam处理
    */
    public function getUrlParam($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, $this->Charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }


    /**
     * 此方法对value做urlencode
    */
    public function getUrlencode($params) {
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, $this->Charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . urlencode($v);
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . urlencode($v);
                }
                $i++;
            }
        }

        unset ($k, $v);
        // urlencode 会把空格转换成 +  这里需要把 + 替换成 %20
        $stringToBeSigned = str_replace('+','%20',$stringToBeSigned);

        return $stringToBeSigned;
    }

}