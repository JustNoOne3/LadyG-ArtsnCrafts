<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lady G Online Shoppe</title>
        @php
            $settings = app(\App\Settings\GeneralSettings::class);
        @endphp
        @if($settings && $settings->site_favicon)
            <link rel="icon" type="image/png" href="{{ Storage::url($settings->site_favicon) }}" />
        @endif
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
        <style>
            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }
        </style>
        @livewireStyles
    </head>
    <body class="bg-white">
        
        <div id="nav-sticky-wrapper" style="position:relative; z-index:50;">
            <div id="nav-sticky-inner" style="position:sticky; top:0; z-index:50;">
                @livewire('compressed-navigation')
            </div>
        </div>
        <div class="w-full h-10 md:h-14 bg-[#e6d9cb] px-2 md:px-40 flex gap-2 md:gap-4 text-[#7a4025] text-sm md:text-md items-center">
            <a class="hover:underline" href="/"> Home </a>
            >
            <a class="hover:underline" href="">Checkout</a>
        </div>
        <div class="min-h-screen bg-[#FAF5F0] py-0 md:py-12 font-poppins" >
            <div class="w-1/2 mx-auto bg-white rounded-lg shadow-lg p-8 flex flex-col gap-8">
                <div class="flex flex-col items-center text-center gap-2">
                    <svg class="w-16 h-16 text-green-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <h1 class="text-2xl font-bold text-green-700">Order Placed Successfully!</h1>
                    <p class="text-gray-700">Thank you for your purchase. Your order has been received and is now under verification.</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mt-4">
                    <h2 class="text-lg font-semibold text-[#7a4025] mb-2">Order Reference</h2>
                    <div class="text-xl font-mono text-[#7a4025]">{{ $order->order_reference }}</div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mt-4">
                    <h2 class="text-lg font-semibold text-[#7a4025] mb-2">Order Summary</h2>
                    <ul class="divide-y divide-gray-200">
                        @foreach(json_decode($order->order_products, true) as $item)
                            <li class="py-2 flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <span class="font-medium">{{ $item['product_name'] }}</span>
                                    <span class="text-xs text-gray-500 ml-2">x{{ $item['quantity'] }}</span>
                                    @if(!empty($item['variant_name']))<span class="text-xs text-gray-400 ml-2">({{ $item['variant_name'] }})</span>@endif
                                    @if(!empty($item['subvariant_name']))<span class="text-xs text-gray-400 ml-2">({{ $item['subvariant_name'] }})</span>@endif
                                </div>
                                <div class="text-right text-[#7a4025] font-semibold">₱{{ number_format($item['product_price'], 2) }}</div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-end mt-4">
                        <span class="font-bold text-[#7a4025] text-lg">Total: ₱{{ number_format($order->order_total, 2) }}</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-[#7a4025] mb-2">Shipping Option</h2>
                        <div>{{ $shippingOption ? $shippingOption->option_name : 'N/A' }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-[#7a4025] mb-2">Shipping Details</h2>
                        @if($shippingDetails)
                            <div><span class="font-medium">Recipient:</span> {{ $shippingDetails->shipping_recipient }}</div>
                            <div><span class="font-medium">Contact:</span> {{ $shippingDetails->shipping_contactNo }}</div>
                            <div><span class="font-medium">Address:</span> {{ $shippingDetails->shipping_street }}, {{ $shippingDetails->shipping_barrangay }}, {{ $shippingDetails->shipping_city }}, {{ $shippingDetails->shipping_province }}, {{ $shippingDetails->shipping_region }}, {{ $shippingDetails->shipping_zip }}</div>
                        @else
                            <div>N/A</div>
                        @endif
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4 mt-6">
                    <h2 class="text-lg font-semibold text-yellow-700 mb-2">Order Under Verification</h2>
                    <p class="text-gray-700">Your order is now pending for verification. You will receive an update via email soon.</p>
                    @if($shippingOption && str_contains(strtolower($shippingOption->option_name), 'delivery'))
                        <p class="mt-2 text-gray-700">Since you selected a delivery option, your email will include the shipping cost and instructions on how to settle it.</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
    </body>
</html>
