<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantSub;

class Cart extends Model
{
    protected $fillable = [
        'cart_user',
        'cart_product',
        'cart_variant',
        'cart_subVariant',
        'cart_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'cart_product');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'cart_variant');
    }

    public function subvariant()
    {
        return $this->belongsTo(VariantSub::class, 'cart_subVariant');
    }
}
