<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantSub;

Route::get('/api/cart/items', function(Request $request) {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $cartItems = Cart::where('cart_user', Auth::id())
        ->with([
            'product:id,product_name,product_thumbnail,product_price',
            'variant:id,variant_name',
            'subvariant:id,subvar_name',
        ])->get()->map(function($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product->product_name ?? '',
                'product_thumbnail' => $item->product->product_thumbnail ?? '',
                'product_price' => $item->product->product_price ?? 0,
                'variant_name' => $item->variant->variant_name ?? '',
                'subvariant_name' => $item->subvariant->subvar_name ?? '',
                'quantity' => $item->cart_quantity,
            ];
        });
    return response()->json($cartItems);
});
