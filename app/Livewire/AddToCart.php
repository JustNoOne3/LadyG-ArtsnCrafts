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
    public $quantity = 1;
    public $showSuccessModal = false;


    public function addToCart()
    {
        Cart::create([
            'cart_user' => Auth::id(),
            'cart_product' => $this->productId,
            'cart_variant' => $this->variantId,
            'cart_subVariant' => $this->subvariantId,
            'cart_quantity' => $this->quantity,
        ]);
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
