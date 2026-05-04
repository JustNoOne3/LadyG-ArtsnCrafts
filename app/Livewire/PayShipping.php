<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\ShippingOptions;
use App\Models\PaymentDetails;

class PayShipping extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $showButton = true;
    public $orderId;
    public $shippingReceipt;
    public $successModal = false;
    public $shippingOption;
    public $amount;
    public $paymentDetails;

    protected $rules = [
        'shippingReceipt' => 'required|image|max:4096',
    ];

    public function mount($orderId, $showButton = true)
    {
        $this->orderId = $orderId;
        $this->showButton = $showButton;

        $order = Order::findOrFail($this->orderId);
        $this->shippingOption = ShippingOptions::find($order->order_shippingMethod)->value('option_name');
        $this->amount = $order->order_shippingFee;
        $this->paymentDetails = PaymentDetails::all();
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->resetErrorBag();
        $this->shippingReceipt = null;
    }

    public function uploadReceipt()
    {
        $this->validate();
        $order = Order::findOrFail($this->orderId);
        $path = $this->shippingReceipt->store('shipping_receipts', 'public');
        $order->order_shippingReceipt = $path;
        $order->order_status = 'Payment Pending Verification';
        $order->save();
        $this->showModal = false;
        $this->successModal = true;
        $this->dispatch('orderUpdated');
    }

    public function closeSuccessModal()
    {
        $this->successModal = false;
    }

    protected $listeners = [];

    // No listeners needed

    public function render()
    {
        return view('livewire.pay-shipping');
    }
}
