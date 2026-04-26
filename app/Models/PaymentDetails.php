<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $fillable = [
        'payment_bankName',
        'payment_accountName',
        'payment_accountNumber',
    ];
}
