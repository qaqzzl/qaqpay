<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTradePay extends Model
{
    protected $table = 'merchant_trade_pay';

    protected $primaryKey = 'pay_id';

    protected $dateFormat = 'U';

    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return $value;
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class,'merchant_id','merchant_id');
    }
}
