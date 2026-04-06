<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantSub extends Model
{
    protected $fillable = [
        'subvar_productId',
        'subvar_variantId',
        'subvar_name',
        'subvar_price',
        'subvar_quantity',
        'subvar_image',
    ];
}
