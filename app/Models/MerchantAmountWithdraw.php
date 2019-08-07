<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantAmountWithdraw extends Model
{
    protected $table = 'merchant_amount_withdraw';

    protected $primaryKey = 'withdraw_id';

    protected $dateFormat = 'U';

    protected $guarded = [];
}
