<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTradePay extends Model
{
    protected $table = 'merchant_trade_pay';

    protected $primaryKey = 'pay_id';

    protected $dateFormat = 'U';

    protected $guarded = [];
}
