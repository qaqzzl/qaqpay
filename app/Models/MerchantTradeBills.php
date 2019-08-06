<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTradeBills extends Model
{
    protected $table = 'merchant_trade_bills';

    protected $primaryKey = 'total_bill_id';

    protected $dateFormat = 'U';

    protected $guarded = [];
}
