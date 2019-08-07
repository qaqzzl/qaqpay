<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Merchant extends Model
{
    protected $table = 'merchant';

    protected $primaryKey = 'merchant_id';

    protected $dateFormat = 'U';

    protected $guarded = [];
    public function setPasswordAttribute($value) {
        if ($value)
            $this->attributes['password'] = md5($value);
    }

    public function setSecretKeyAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['secret_key'] = Uuid::uuid4();
        }
    }
}
