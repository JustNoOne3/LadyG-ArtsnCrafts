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
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a class="hover:underline" href="">Cart</a>
        </div>
        <div class="min-h-screen bg-[#FAF5F0] py-0 md:py-12 font-poppins" >
            <div x-data="cartPage()" x-init="init(); fetchCart()" class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8 flex flex-col gap-8">
                <template x-if="cart.length === 0">
                    <div class="text-center text-gray-500 text-lg">Your cart is empty.</div>
                </template>
                <template x-if="cart.length > 0">
                    <form @submit.prevent class="flex flex-col gap-6">
                        <div class="overflow-x-auto">
                            <div class="flex items-center mb-2 gap-4">
                                <button type="button" @click="selectAll()" class="px-4 py-1 rounded bg-[#e6d9cb] text-[#7a4025] font-semibold hover:bg-[#d6c3b3]">Select All</button>
                            </div>
                            <table class="min-w-full text-left border-separate border-spacing-y-4">
                                <thead>
                                    <tr class="text-[#7a4025] font-bold text-lg">
                                        <th class="w-12 text-center"> </th>
                                        <th>Product Details</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="item in cart" :key="item.id">
                                        <tr class="bg-[#f8f8f8] rounded-lg shadow border border-[#e6d9cb] align-top">
                                            <td class="py-4 px-2 text-center align-middle">
                                                <input type="checkbox" :value="item.id" :checked="selected.includes(item.id)" @change="toggleSelection(item.id)" class="w-5 h-5 accent-[#7a4025] align-middle">
                                            </td>
                                            <td class="py-4 px-2">
                                                <div class="flex gap-4 items-center">
                                                    <img :src="'/storage/' + item.product_thumbnail" alt="" class="w-20 h-20 object-cover rounded-lg border shadow" />
                                                    <div class="flex flex-col gap-1">
                                                        <span class="font-bold text-lg text-[#7a4025]" x-text="item.product_name"></span>
                                                        <template x-if="item.variant_name">
                                                            <span class="text-sm text-gray-600">Variant: <span x-text="item.variant_name"></span></span>
                                                        </template>
                                                        <template x-if="item.subvariant_name">
                                                            <span class="text-sm text-gray-600">Subvariant: <span x-text="item.subvariant_name"></span></span>
                                                        </template>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center min-w-[120px]">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" @click="decrementQty(item); if(selected.includes(item.id)) updateTotal();" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-xl font-bold flex items-center justify-center">-</button>
                                                    <span class="inline-block w-8 text-center font-semibold" x-text="item.quantity"></span>
                                                    <button type="button" @click="incrementQty(item); if(selected.includes(item.id)) updateTotal();" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-xl font-bold flex items-center justify-center">+</button>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-right align-top font-bold text-[#7a4025] text-lg">₱<span x-text="formatPrice(item.product_price * item.quantity)"></span></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
        
                        <template x-if="errorMsg">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-2 text-sm" x-html="errorMsg"></div>
                        </template>
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6 border-t pt-6">
                            <div class="text-xl font-bold text-[#7a4025]">Total: ₱<span x-text="formatPrice(total)"></span></div>
                            <div class="flex flex-col gap-2 w-full md:w-auto">
                                <div class="flex gap-4">
                                    <button type="button" @click="window.location.href='/'" class="flex-1 md:flex-none px-6 py-2 rounded bg-gray-200 text-[#7a4025] font-semibold hover:bg-gray-300">Continue Shopping</button>
                                    <button type="button" :disabled="selected.length === 0" @click="submitCheckout()" class="flex-1 md:flex-none px-6 py-2 rounded bg-[#7a4025] text-white font-semibold hover:bg-[#63321c] disabled:opacity-50">Checkout</button>
                                    <form id="checkoutForm" method="POST" action="{{ route('cart.checkout') }}" style="display:none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                </template>
            </div>
        </div>
        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
        function cartPage() {
            return {
                cart: [],
                selected: [],
                total: 0,
                allSelected: false,
                init() {
                    this.$watch('selected', () => {
                        this.updateTotal();
                    });
                },
                errorMsg: '',
                async submitCheckout() {
                    this.errorMsg = '';
                    if (this.selected.length === 0) return;
                    // Save modified quantities to backend before validating stock
                    const updateRes = await fetch('/api/cart/update-quantities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            items: this.cart.filter(i => this.selected.includes(i.id)).map(i => ({ id: i.id, quantity: i.quantity }))
                        })
                    });
                    const updateResult = await updateRes.json();
                    if (!updateResult.success) {
                        this.errorMsg = updateResult.message || 'Failed to update cart quantities.';
                        return;
                    }
                    // Validate stock before submitting
                    const response = await fetch('/api/cart/validate-stock', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ selected: this.selected })
                    });
                    const result = await response.json();
                    if (!result.success) {
                        let msg = 'Some items have insufficient stock:';
                        if (result.errors && Array.isArray(result.errors)) {
                            msg += '<ul class="list-disc pl-5">' + result.errors.map(e => `<li>${e.product_name}: requested ${e.requested}, available ${e.available}</li>`).join('') + '</ul>';
                        } else if (result.message) {
                            msg += '<br>' + result.message;
                        }
                        this.errorMsg = msg;
                        return;
                    }
                    // If stock is valid, submit the form
                    const form = document.getElementById('checkoutForm');
                    Array.from(form.querySelectorAll('input[name="selected[]"]')).forEach(e => e.remove());
                    this.selected.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                    form.submit();
                },
                fetchCart() {
                    fetch('/api/cart/items')
                        .then(r => r.json())
                        .then(data => {
                            this.cart = data;
                            this.selected = [];
                            this.$nextTick(() => this.updateTotal());
                        });
                },
                selectAll() {
                    this.selected = this.cart.map(i => i.id);
                    this.$nextTick(() => this.updateTotal());
                },
                toggleAll(e) {
                    if (e.target.checked) {
                        this.selected = this.cart.map(i => i.id);
                    } else {
                        this.selected = [];
                    }
                    this.$nextTick(() => this.updateTotal());
                },
                toggleSelection(id) {
                    if (this.selected.includes(id)) {
                        this.selected = this.selected.filter(i => i !== id);
                    } else {
                        this.selected = [...this.selected, id];
                    }
                },
                formatPrice(val) {
                    return Number(val).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
                },
                updateTotal() {
                    // Always recalculate total based on selected and current quantities
                    let sum = 0;
                    for (const i of this.cart) {
                        if (this.selected.includes(i.id)) {
                            sum += (parseFloat(i.product_price) * parseInt(i.quantity));
                        }
                    }
                    this.total = sum;
                },
                incrementQty(item) {
                    item.quantity++;
                    if(this.selected.includes(item.id)) this.updateTotal();
                },
                decrementQty(item) {
                    if (item.quantity > 1) {
                        item.quantity--;
                        if(this.selected.includes(item.id)) this.updateTotal();
                    }
                },
            };
        }
        </script>
    </body>
</html>
