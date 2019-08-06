<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutTradePayLog extends Model
{
    protected $table = 'out_trade_pay_log';

    protected $primaryKey = 'log_id';

    protected $dateFormat = 'U';

    public $timestamps = false;

    protected $guarded = [];
}
