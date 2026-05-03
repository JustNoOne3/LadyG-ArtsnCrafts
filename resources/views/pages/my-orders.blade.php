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
            <a class="hover:underline" href="">My Orders</a>
        </div>
        <div class="min-h-screen bg-[#FAF5F0] py-0 md:py-12 font-poppins" >
            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8 flex flex-col gap-8">
                <h1 class="text-2xl font-bold text-[#7a4025] mb-6 text-center">My Orders</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#e6d9cb]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#7a4025] uppercase tracking-wider">Reference #</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#7a4025] uppercase tracking-wider">Order Summary</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#7a4025] uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-[#7a4025] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-[#faf5f0] transition">
                                    <td class="px-4 py-3 font-mono text-[#7a4025] font-bold">{{ $order->order_reference }}</td>
                                    <td class="px-4 py-3">
                                        <ul class="list-disc ml-4 text-sm text-gray-700">
                                            @foreach($order->order_products as $item)
                                                <li>
                                                    <span class="font-medium">{{ $item['product_name'] }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">x{{ $item['quantity'] }}</span>
                                                    @if(!empty($item['variant_name']))<span class="text-xs text-gray-400 ml-1">({{ $item['variant_name'] }})</span>@endif
                                                    @if(!empty($item['subvariant_name']))<span class="text-xs text-gray-400 ml-1">({{ $item['subvariant_name'] }})</span>@endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold items-center justify-center text-center
                                            @if($order->order_status == 'Pending for Verification') bg-yellow-100 text-yellow-800
                                            @elseif($order->order_status == 'Cancelled') bg-red-100 text-red-800
                                            @elseif($order->order_status == 'Completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center flex flex-col items-center justify-center gap-2">
                                        {{-- <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="inline"> --}}
                                        @if($order->order_status == 'Pending for Verification')
                                            <a href="" class="inline-flex items-center px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded transition" @if($order->order_status == 'Cancelled' || $order->order_status == 'Completed') hidden @endif>
                                                Cancel Order
                                            </a>
                                        @endif
                                        @if($order->order_status == 'Waiting for Payment')
                                            <livewire:pay-shipping :order-id="$order->id" :key="$order->id" />
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-400">You have no orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
    </body>
</html>
