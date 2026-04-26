<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\VariantSub;

class CheckoutController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->all();
        if (empty($data['selected_address']) || $data['selected_address'] == 'null') {
            $request->merge(['selected_address' => $data['selected_address_fake']]);
        }
        // dd($data, $request->all());
        try {
            $validated = $request->validate([
                'shipping_method' => 'required|exists:shipping_options,id',
                'selected_address' => 'required|exists:shipping_details,id',
                'payment_receipt_tmp' => 'required|string',
            ]);

            if (empty($validated['selected_address'])) {
                return back()->withInput()->with('error', 'Please select a shipping address.');
            }

            $tmpFilename = $request->input('payment_receipt_tmp');
            $tmpPath = storage_path('app/public/livewire-tmp/' . $tmpFilename);
            $newFilename = uniqid('receipt_') . '.' . pathinfo($tmpFilename, PATHINFO_EXTENSION);
            $fileSaved = "receipts/" . $newFilename;
            $newPath = storage_path('app/public/receipts/' . $newFilename);
            if (!file_exists($tmpPath)) {
                return back()->withInput()->with('error', 'Uploaded file not found.');
            }
            rename($tmpPath, $newPath);

            $orderProducts = collect(json_decode($request->input('order_products', '[]'), true))
                ->map(function ($item) {
                    return [
                        'product_id' => $item['id'],
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'product_price' => $item['product_price'],
                        'variant_name' => $item['variant_name'] ?? null,
                        'subvariant_name' => $item['subvariant_name'] ?? null,
                    ];
                })->toArray();

            foreach ($orderProducts as $item) {
                $cart = Cart::where('id', $item['product_id'])->first();
                $subVar = VariantSub::where('id', $cart->cart_subVariant)->first();
                if($subVar->subvar_quantity > $cart->cart_quantity){
                    $subVar->subvar_quantity -= $cart->cart_quantity;
                    $subVar->save();
                } else {
                    return back()->withInput()->with('error', 'Insufficient stock for the selected product/variant. ('.$item['product_name'].')');
                }
                if ($cart) {
                    $cart->delete();
                }
            }

            $order = Order::create([
                'order_reference' => strtoupper(Str::random(10)),
                'order_userId' => Auth::id(),
                'order_products' => json_encode($orderProducts),
                'order_total' => $request->input('order_total'),
                'order_shippingMethod' => $request->input('shipping_method'),
                'order_shippingAddress' => $request->input('selected_address'),
                'order_purchaseReceipt' => $fileSaved,
                'order_status' => 'Pending for Verification',
            ]);
            
            return redirect()->route('checkout.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'An error occurred while placing your order. Please try again or contact support.');
        }
    }
}
