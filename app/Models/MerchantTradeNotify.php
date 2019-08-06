<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTradeNotify extends Model
{
    protected $table = 'merchant_trade_notify';

    protected $primaryKey = 'notify_id';

    protected $dateFormat = 'U';

    protected $guarded = [];
}
