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
class MerchantService {

    //验证用户密码
//    public function verifyPassword

}