<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantAmountWithdraw extends Model
{
    protected $table = 'merchant_amount_withdraw';

    protected $primaryKey = 'withdraw_id';

    protected $dateFormat = 'U';

    protected $guarded = [];

    public function merchant()
    {
        return $this->hasOne(Merchant::class,'merchant_id','merchant_id');
    }
}
