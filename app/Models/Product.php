<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_salePrice',
        'product_quantity',
        'product_soldCount',
        'product_thumbnail',
        'product_images',
        'product_brand',
        'product_category',
    ];
}
