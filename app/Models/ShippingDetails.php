<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDetails extends Model
{
    protected $fillable = [
        'shipping_user',
        'shipping_recipient', //
        'shipping_street',
        'shipping_barrangay',
        'shipping_city',
        'shipping_province',
        'shipping_region',
        'shipping_zip',
        'shipping_contactNo', //
        'shipping_address',
        'shipping_isDefault',
    ];

    public function orders() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
