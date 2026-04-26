<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_reference', // auto generated unique reference number
        'order_userId', // foreign key to users table
        'order_products', // field containing product details (id, name, quantity, price)
        'order_total', // total amount of the order
        'order_shippingMethod', // shipping method chosen by the user
        'order_shippingAddress', // shipping address provided by the user - the foreign key to the shipping details table
        'order_shippingReceipt', // receipt for the shipping
        'order_purchaseReceipt', // receipt for the purchase
        'order_status',
    ];

    
}
