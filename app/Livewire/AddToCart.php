<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $productId;
    public $variantId;
    public $subvariantId;
    public $quantity;
    public $showSuccessModal = false;


    public function addToCart()
    {
        $userId = auth()->user()->id;
        $existing = Cart::where('cart_user', $userId)
            ->where('cart_product', $this->productId)
            ->where('cart_variant', $this->variantId)
            ->where('cart_subVariant', $this->subvariantId)
            ->first();

        dd('User ID: ' . $userId, 'Existing Cart: ' . json_encode($existing), 'Product ID: ' . $this->productId, 'Variant ID: ' . $this->variantId, 'Subvariant ID: ' . $this->subvariantId);
        if ($existing) {
            $existing->cart_quantity += $this->quantity;
            $existing->save();
        } else {
            Cart::create([
                'cart_user' => $userId,
                'cart_product' => $this->productId,
                'cart_variant' => $this->variantId,
                'cart_subVariant' => $this->subvariantId,
                'cart_quantity' => $this->quantity,
            ]);
        }
        $this->showSuccessModal = true;
        $this->emit('cartUpdated');
    }

    public function closeModal()
    {
        $this->showSuccessModal = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
