<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvancePaymentSetting extends Model
{
    protected $fillable = ['advance_payment_status', 'advance_payment_amount'];

    public static function current()
    {
        return self::first() ?? self::create(['advance_payment_status' => false]);
    }
}
