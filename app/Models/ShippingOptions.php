<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingOptions extends Model
{
    protected $fillable = [
        'option_name',
    ];

    public function orders() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
