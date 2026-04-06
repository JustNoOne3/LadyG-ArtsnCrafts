<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'variant_productId',
        'variant_name',
        'variant_decscription',
        'variant_price',
        'variant_quantity',
        'variant_image',
    ];
}
