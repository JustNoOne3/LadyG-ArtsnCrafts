<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model

{
    protected $fillable = [
        'order_reference', // auto generated unique reference number
        'order_userId', // foreign key to users table
        'order_products', // field containing product details (id, name, quantity, price)
        'order_total', // total amount of the order
        'order_shippingMethod', // shipping method chosen by the user
        'order_shippingAddress', // shipping address provided by the user - the foreign key to the shipping details table
        'order_shippingFee', // shipping fee based on the chosen shipping method
        'order_shippingReceipt', // receipt for the shipping
        'order_purchaseReceipt', // receipt for the purchase
        'order_status',
    ];

    protected $casts = [
        'order_products' => 'array', // cast order_products to an array
    ];

    
    public function shippingOption()
    {
        return $this->belongsTo(\App\Models\ShippingOptions::class, 'order_shippingMethod', 'id');
    }

    public function shippingDetails()
    {
        return $this->belongsTo(\App\Models\ShippingDetails::class, 'order_shippingAddress', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'order_userId', 'id');
    }
}
