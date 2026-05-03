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
            /* Custom radio color for all browsers */
            input[type="radio"].accent-7a4025:checked {
                accent-color: #7a4025;
            }
            /* For Safari and fallback */
            input[type="radio"].accent-7a4025:checked {
                background-color: #7a4025;
                border-color: #7a4025;
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8 flex flex-col gap-8">
                                @if(session('error'))
                                    <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                                        <strong>Error:</strong> {{ session('error') }}
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                                        <strong>Success:</strong> {{ session('success') }}
                                    </div>
                                @endif
                <div x-data="{ ready: false, ...checkoutPage() }" x-init="init(); setTimeout(() => ready = true, 600)">
                    <!-- Skeleton Loader -->
                    <div x-show="!ready" class="animate-pulse flex flex-col gap-8">
                        <div class="h-8 bg-gray-200 rounded w-1/3 mb-4"></div>
                        <div class="space-y-4">
                            <div class="h-24 bg-gray-200 rounded"></div>
                            <div class="h-24 bg-gray-200 rounded"></div>
                        </div>
                        <div class="h-8 bg-gray-200 rounded w-1/4 mb-4"></div>
                        <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                        <div class="h-40 bg-gray-200 rounded mb-4"></div>
                        <div class="h-12 bg-gray-200 rounded w-1/3"></div>
                    </div>
                    <!-- Actual Form -->
                    <form method="POST" action="{{ route('checkout.submit') }}" enctype="multipart/form-data" x-show="ready" x-cloak @submit="return handleOrderSubmit($event)" x-data="checkoutFormComponent({ items, total })">
                    @csrf
                    <!-- Hidden fields for backend -->
                    <input type="hidden" name="order_products" :value="JSON.stringify(items)">
                    <input type="hidden" name="order_total" :value="total">
                    <input type="hidden" name="shipping_method" :value="shippingMethod">
                    <input type="hidden" name="selected_address" x-ref="selectedAddressHidden" :value="selectedAddressId ? String(selectedAddressId) : ''">
                    <input type="hidden" name="payment_receipt_tmp" x-model="paymentReceiptTmp">
                    <div @address-selected.window="selectedAddressId = $event.detail.id"></div>
                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('checkoutFormComponent', (props) => ({
                                ...checkoutFormComponent(props),
                                handleOrderSubmit(e) {
                                    // Copy checked radio value to hidden field before submit
                                    const checked = document.querySelector('input[name=selected_address_fake]:checked');
                                    if (checked && this.$refs.selectedAddressHidden) {
                                        this.$refs.selectedAddressHidden.value = checked.value;
                                        this.selectedAddressId = checked.value;
                                    }
                                    if (!this.canPlaceOrder) {
                                        e.preventDefault();
                                        return false;
                                    }
                                    return true;
                                },
                            }));
                        });
                    </script>
                                        @csrf
                                        <!-- Listen for payment-uploaded event to update hidden field -->
                                        <div @payment-uploaded.window="paymentReceiptTmp = $event.detail.filename"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-[#7a4025] mb-4">Order Summary</h2>
                        <div class="mb-6">
                            <template x-for="item in items" :key="item.id">
                                <div class="flex items-center gap-4 bg-[#f8f8f8] rounded-lg shadow border border-[#e6d9cb] mb-4 p-4">
                                    <img :src="'/storage/' + item.product_thumbnail" alt="" class="w-20 h-20 object-cover rounded-lg border shadow" />
                                    <div class="flex flex-col flex-1">
                                        <span class="font-bold text-lg text-[#7a4025]" x-text="item.product_name"></span>
                                        <div class="text-sm text-gray-600" x-show="item.variant_name || item.subvariant_name">
                                            <template x-if="item.variant_name">
                                                <span x-text="item.variant_name"></span>
                                            </template>
                                            <template x-if="item.subvariant_name">
                                                <span x-text="item.subvariant_name"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end min-w-[120px]">
                                        <span class="text-gray-700">Qty: <span x-text="item.quantity"></span></span>
                                        <span class="font-semibold text-[#7a4025]">₱<span x-text="formatPrice(item.product_price)"></span></span>
                                        <span class="text-sm text-gray-500">Subtotal:</span>
                                        <span class="font-bold text-[#7a4025] text-lg">₱<span x-text="formatPrice(item.product_price * item.quantity)"></span></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="text-xl font-bold text-[#7a4025] text-right mb-6">
                            Total: ₱<span x-text="formatPrice(total)"></span>
                        </div>
                    </div>


                    <!-- Shipping Method -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-[#7a4025] mb-2">Shipping Method</h2>
                        <div class="flex flex-col gap-6 px-6 py-4">
                            @foreach($shippingOptions as $option)
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="shipping_method_fake" value="{{ $option->id }}" x-model="shippingMethod" @change="shippingMethod = $event.target.value" required>
                                    {{ $option->option_name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Details Section -->
                    <div x-show="shippingMethod && !isPickUpSelected()" class="mb-8 transition-all duration-300" x-data="shippingDetailsComponent()">
                        <h2 class="text-xl font-bold text-[#7a4025] mb-2">Shipping Address</h2>
                        <div class="bg-[#f8f8f8] border rounded p-4 text-[#7a4025] flex flex-col gap-4">
                            <!-- Modal for address saved -->
                            <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
                                <div class="bg-black bg-opacity-40 absolute inset-0"></div>
                                <div class="bg-white rounded-lg shadow-lg p-6 z-10 flex flex-col items-center">
                                    <div class="text-[#7a4025] text-5xl mb-2">✔</div>
                                    <div class="font-semibold text-xl mb-2">Address saved!</div>
                                    <button @click="showModal = false" class="mt-2 px-4 py-2 bg-[#7a4025] text-white rounded hover:bg-[#A8684C]">OK</button>
                                </div>
                            </div>
                            <p>Please provide your shipping address details below:</p>
                            <input type="text" x-model="form.recipient_name" placeholder="Recipient Name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            <div class="flex flex-col md:flex-row gap-4">
                                <input type="text" x-model="form.street_address" placeholder="Street/House No./Purok" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                                <input type="text" x-model="form.barrangay" placeholder="Barrangay" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            </div>
                            <div class="flex flex-col md:flex-row gap-4">
                                <input type="text" x-model="form.city" placeholder="City/Municipality" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                                <input type="text" x-model="form.province" placeholder="Province" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            </div>
                            <div class="flex flex-col md:flex-row gap-4">
                                <input type="text" x-model="form.region" placeholder="Region" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                                <input type="text" x-model="form.postal_code" placeholder="Postal Code/ZIP Code" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            </div>
                            <input type="text" x-model="form.contact_number" placeholder="Contact Number" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            <div class="flex justify-between gap-8">
                                <div class="flex flex-row items-center justify-start">
                                    <input type="checkbox" x-model="form.is_default_address" id="default_address" class="mr-2" :disabled="isDefaultMode && !isEditMode">
                                    <label for="default_address" class="hidden md:block ">Set as default address?</label>
                                    <label for="default_address" class="block md:hidden">Default?</label>
                                </div>
                                <div class="flex flex-col md:flex-row gap-2">
                                    <template x-if="isEditMode">
                                        <button type="button" @click="updateAddress" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Save Changes</button>
                                    </template>
                                    <template x-if="isEditMode || isDefaultMode">
                                        <button type="button" @click="switchToAddMode" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">+ Add New Address</button>
                                    </template>
                                    <template x-if="!isEditMode && !isDefaultMode">
                                        <button type="button" @click="saveAddress" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Save Address</button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <!-- Saved Addresses Section -->
                        <div class="mt-6">
                            <h3 class="font-semibold mb-2">Pick a saved address:</h3>
                            <template x-if="addresses.length === 0">
                                <div class="text-gray-500 text-sm">No saved addresses yet.</div>
                            </template>
                            <div
                                class="overflow-y-auto"
                                :class="{
                                    'max-h-[176px] grid grid-cols-1 md:grid-cols-2 md:max-h-[180px] gap-2': addresses.length > 0
                                }"
                                x-show="addresses.length > 0"
                            >
                                <template x-for="address in addresses" :key="address.id">
                                    <div
                                        class="flex items-center gap-2 p-2 md:p-4 border rounded cursor-pointer hover:bg-gray-100"
                                        :class="selectedAddressId === address.id ? 'ring-2 ring-[#7a4025] bg-[#f3ece6] border-[#7a4025]' : ''"
                                        @click="selectedAddressId = address.id; fillForm(address);"
                                    >
                                        <input
                                            type="radio"
                                            name="selected_address_fake"
                                            :value="address.id"
                                            x-model="selectedAddressId"
                                            @change="selectedAddressId = String(address.id); fillForm(address)"
                                            class="accent-7a4025"
                                        >
                                        <div class="flex justify-between w-full">
                                            <div>
                                                <div class="font-bold" x-text="address.shipping_recipient"></div>
                                                <div class="text-xs" x-text="address.shipping_address"></div>
                                            </div>
                                            <div class="text-xs font-bold text-[#7a4025]" x-show="address.shipping_isDefault == '1'">Default</div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-[#7a4025] mb-2">Payment & Shipping Instructions</h2>
                        <div class="bg-[#f8f8f8] border rounded p-4 text-[#7a4025] flex flex-col gap-4">
                            <p>Please transfer your payment to one of the following accounts and upload your payment receipt below:</p>
                            <ul class="list-disc ml-6 mt-2">
                                @foreach($paymentDetails as $payment)
                                    <li>
                                        <span class="font-semibold">{{ $payment->payment_bankName }}:</span>
                                        <span>{{ $payment->payment_accountNumber }}</span>
                                        @if($payment->payment_accountName)
                                            ({{ $payment->payment_accountName }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                After placing your order, our team will verify your payment and process your order.
                            </p>
                            <br/>
                            <p class="text-justify">
                                If you have chosen a <strong>Delivery Option</strong>,
                                <br>
                                Please verify that your shipping details are accurate before finalizing your request. Once your order is processed, you will receive an <strong>email notification</strong> detailing the total shipping costs.
                                <br>
                                To complete your transaction, please navigate to your <strong>My Orders</strong> page, select the pending order, and click <strong>Pay Shipping</strong>. From there, you can securely settle the balance and upload your payment receipt. Alternatively, you may use the direct link provided in the email to finalize your order.
                            </p>
                            {{-- <p>
                                If you have any questions or need assistance, please contact our customer support at <a href="mailto:support@example.com"><strong>support@example.com</strong></a>.
                            </p> --}}
                        </div>
                    </div>

                    <!-- Payment Receipt Upload -->
                    <div class="mb-8" x-data="fileUploadComponent()">
                        <h2 class="text-xl font-bold text-[#7a4025] mb-2">Upload Payment Receipt</h2>
                        <div
                            class="relative flex flex-col items-center justify-center border-2 border-dashed rounded-lg p-6 bg-[#f8f8f8] transition hover:border-[#7a4025] hover:bg-[#f3ece6] min-h-[180px] w-full cursor-pointer"
                            :class="{ 'border-[#7a4025]': isDragging, 'border-gray-300': !isDragging }"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            @click="fileInput.click()"
                        >
                            <!-- Placeholder (only show if no file selected and not loading) -->
                            <template x-if="!hasFile && !loading">
                                <div class="flex flex-col items-center justify-center w-full h-full">
                                    <svg class="w-12 h-12 text-[#7a4025] mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 10l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                    <span class="text-[#7a4025] font-semibold">Drag & drop or click to upload</span>
                                    <span class="text-xs text-gray-500">Accepted: image/*, PDF</span>
                                </div>
                            </template>
                            <input
                                type="file"
                                accept="image/*,application/pdf"
                                class="hidden"
                                x-ref="fileInput"
                                @change="uploadPaymentReceipt"
                                required
                            >
                            <template x-if="loading">
                                <div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-70 rounded-lg">
                                    <svg class="animate-spin h-8 w-8 text-[#7a4025]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </div>
                            </template>
                            <template x-if="previewUrl && !loading">
                                <div class="mt-4 w-full flex flex-col items-center">
                                    <template x-if="isImage">
                                        <img :src="previewUrl" alt="Preview" class="max-h-40 rounded shadow border mb-2">
                                    </template>
                                    <template x-if="!isImage">
                                        <div class="flex flex-col items-center bg-white border rounded shadow p-4 w-full max-w-xs mb-2">
                                            <svg class="w-10 h-10 text-[#7a4025] mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7V3h10v4M7 7h10M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7M7 7H5a2 2 0 00-2 2v10a2 2 0 002 2h2" />
                                            </svg>
                                            <span class="font-semibold text-[#7a4025] text-sm truncate w-full" x-text="fileName"></span>
                                            <span class="text-xs text-gray-500" x-text="fileSize"></span>
                                        </div>
                                    </template>
                                    <button type="button" class="mt-2 px-4 py-1 rounded bg-gray-200 text-[#7a4025] font-semibold hover:bg-gray-300" @click.stop="removeFile">Remove</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-8 py-3 rounded bg-[#7a4025] text-white font-semibold hover:bg-[#63321c] disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!canPlaceOrder"
                        >
                            Place Order
                        </button>
                    </div>
                    <!-- Order Success Modal -->
                    <div x-show="showOrderModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="bg-black bg-opacity-40 absolute inset-0"></div>
                        <div class="bg-white rounded-lg shadow-lg p-6 z-10 flex flex-col items-center">
                            <div class="text-[#7a4025] text-5xl mb-2">✔</div>
                            <div class="font-semibold text-xl mb-2">Order placed!</div>
                            <div class="mb-2 text-center">Your order will undergo verification. You will be notified once it is processed.</div>
                            <button @click="showOrderModal = false; window.location.href = '/'" class="mt-2 px-4 py-2 bg-[#7a4025] text-white rounded hover:bg-[#A8684C]">OK</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <style>
            [x-cloak] { display: none !important; }
        </style>
        <script>
        document.addEventListener('alpine:init', () => {
            if (@json(session('success'))) {
                setTimeout(() => {
                    const root = document.querySelector('form[x-data]');
                    if (root && root.__x) {
                        root.__x.$data.showOrderModal = true;
                    }
                }, 300);
            }
        });
        function checkoutFormComponent(props) {
            return {
                items: props.items,
                total: props.total,
                shippingMethod: '',
                selectedAddressId: '', // always a string
                paymentReceiptTmp: '',
                hasFile: false,
                showOrderModal: false,
                canPlaceOrder: false,
                init() {
                    this.observeFields();
                },
                observeFields() {
                    this.$watch('shippingMethod', () => this.validateForm());
                    this.$watch('selectedAddressId', () => this.validateForm());
                    this.$watch('paymentReceiptTmp', () => this.validateForm());
                    this.validateForm();
                },
                uploadPaymentReceipt(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const formData = new FormData();
                    formData.append('file', file);
                    fetch('/file-upload/tmp', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.paymentReceiptTmp = data.filename;
                            this.hasFile = true;
                        } else {
                            alert('File upload failed.');
                            this.paymentReceiptTmp = '';
                            this.hasFile = false;
                        }
                        this.validateForm();
                    })
                    .catch(() => {
                        alert('File upload failed.');
                        this.paymentReceiptTmp = '';
                        this.hasFile = false;
                        this.validateForm();
                    });
                },
                validateForm() {
                    if (!this.shippingMethod) { this.canPlaceOrder = false; return; }
                    let isPickup = false;
                    const pickUpOption = Array.from(this.$el.querySelectorAll('input[name=shipping_method_fake]')).find(el => el.nextSibling.textContent.trim().toLowerCase().includes('pick-up'));
                    if (pickUpOption && pickUpOption.checked) isPickup = true;
                    if (!isPickup) {
                        if (!this.selectedAddressId) { this.canPlaceOrder = false; return; }
                    }
                    if (!this.paymentReceiptTmp) { this.canPlaceOrder = false; return; }
                    this.canPlaceOrder = true;
                },
                handleOrderSubmit(e) {
                    if (!this.canPlaceOrder) {
                        e.preventDefault();
                        return false;
                    }
                    return true;
                },
            }
        }
        function shippingDetailsComponent() {
            return {
                form: {
                    recipient_name: '',
                    street_address: '',
                    barrangay: '',
                    city: '',
                    province: '',
                    region: '',
                    postal_code: '',
                    contact_number: '',
                    is_default_address: false,
                },
                addresses: [],
                selectedAddressId: '',
                showModal: false,
                isDefaultMode: false,
                isEditMode: false,
                editAddressId: null,
                saveAddress() {
                    const payload = {
                        recipient_name: this.form.recipient_name,
                        street_address: this.form.street_address,
                        barrangay: this.form.barrangay,
                        city: this.form.city,
                        province: this.form.province,
                        region: this.form.region,
                        postal_code: this.form.postal_code,
                        contact_number: this.form.contact_number,
                        is_default_address: this.form.is_default_address ? 1 : 0,
                    };
                    fetch('/shipping-details/save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.fetchAddresses(() => {
                                // Find the address with the highest id (most recently created)
                                let newest = this.addresses.reduce((max, addr) => addr.id > max.id ? addr : max, this.addresses[0]);
                                if (newest) {
                                    // Switch to edit mode for the new address
                                    this.fillForm(newest, true);
                                }
                                this.showModal = true;
                            });
                        } else {
                            alert('Failed to save address.');
                        }
                    });
                },
                updateAddress() {
                    if (!this.editAddressId) return;
                    const payload = {
                        id: this.editAddressId,
                        recipient_name: this.form.recipient_name,
                        street_address: this.form.street_address,
                        barrangay: this.form.barrangay,
                        city: this.form.city,
                        province: this.form.province,
                        region: this.form.region,
                        postal_code: this.form.postal_code,
                        contact_number: this.form.contact_number,
                        is_default_address: this.form.is_default_address ? 1 : 0,
                    };
                    fetch('/shipping-details/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.fetchAddresses(() => {
                                let updated = this.addresses.find(a => a.id === this.editAddressId);
                                if (updated) {
                                    this.fillForm(updated, true);
                                }
                                this.showModal = true;
                            });
                        } else {
                            alert('Failed to update address.');
                        }
                    });
                },
                fetchAddresses(afterFetch) {
                    fetch('/shipping-details/list')
                        .then(res => res.json())
                        .then(data => {
                            this.addresses = data.addresses || [];
                            if (typeof afterFetch === 'function') {
                                afterFetch();
                            } else {
                                const def = this.addresses.find(a => a.shipping_isDefault == '1');
                                if (def) {
                                    this.fillForm(def, false);
                                } else {
                                    this.isDefaultMode = false;
                                    this.isEditMode = false;
                                    this.editAddressId = null;
                                }
                            }
                        });
                },
                fillForm(address, isEdit = true) {
                    this.form.recipient_name = address.shipping_recipient;
                    this.form.street_address = address.shipping_street;
                    this.form.barrangay = address.shipping_barrangay;
                    this.form.city = address.shipping_city;
                    this.form.province = address.shipping_province;
                    this.form.region = address.shipping_region;
                    this.form.postal_code = address.shipping_zip;
                    this.form.contact_number = address.shipping_contactNo;
                    this.form.is_default_address = address.shipping_isDefault == '1';
                    this.isDefaultMode = address.shipping_isDefault == '1';
                    this.isEditMode = isEdit;
                    this.editAddressId = isEdit ? address.id : null;
                    this.selectedAddressId = String(address.id);
                },
                switchToAddMode() {
                    this.form = {
                        recipient_name: '',
                        street_address: '',
                        barrangay: '',
                        city: '',
                        province: '',
                        region: '',
                        postal_code: '',
                        contact_number: '',
                        is_default_address: false,
                    };
                    this.isDefaultMode = false;
                    this.isEditMode = false;
                    this.editAddressId = null;
                },
                init() {
                    this.fetchAddresses();
                }
            }
        }
            function fileUploadComponent() {
                return {
                    isDragging: false,
                    loading: false,
                    previewUrl: '',
                    isImage: false,
                    fileName: '',
                    fileSize: '',
                    hasFile: false,
                    fileInput: null,
                    init() {
                        this.fileInput = this.$refs.fileInput;
                    },
                    handleDrop(e) {
                        this.isDragging = false;
                        const files = e.dataTransfer.files;
                        if (files.length) {
                            this.fileInput.files = files;
                            this.fileInput.dispatchEvent(new Event('change'));
                        }
                    },
                    uploadPaymentReceipt(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        this.loading = true;
                        const formData = new FormData();
                        formData.append('file', file);
                        fetch('/file-upload/tmp', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.fileName = file.name;
                                this.fileSize = this.formatFileSize(file.size);
                                this.hasFile = true;
                                this.isImage = file.type.startsWith('image/');
                                // Remove name attribute so file is not submitted
                                this.$refs.fileInput.removeAttribute('name');
                                this.$dispatch('payment-uploaded', { filename: data.filename });
                            } else {
                                alert('File upload failed.');
                                this.hasFile = false;
                            }
                            this.loading = false;
                        })
                        .catch(() => {
                            alert('File upload failed.');
                            this.hasFile = false;
                            this.loading = false;
                        });
                    },
                    removeFile() {
                        this.previewUrl = '';
                        this.fileName = '';
                        this.fileSize = '';
                        this.isImage = false;
                        this.hasFile = false;
                        this.fileInput.value = '';
                        this.$dispatch('payment-uploaded', { filename: '' });
                    },
                    formatFileSize(size) {
                        if (size < 1024) return size + ' bytes';
                        if (size < 1024 * 1024) return (size / 1024).toFixed(1) + ' KB';
                        return (size / (1024 * 1024)).toFixed(2) + ' MB';
                    },
                }
            }
            function checkoutPage() {
                return {
                    items: @json($checkoutItems ?? []),
                    total: 0,
                    shippingMethod: '',
                    formatPrice(val) {
                        return Number(val).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
                    },
                    calcTotal() {
                        this.total = this.items.reduce((sum, i) => sum + (parseFloat(i.product_price) * parseInt(i.quantity)), 0);
                    },
                    init() {
                        this.calcTotal();
                    },
                    isPickUpSelected() {
                        // Find the Pick-Up option by name (case-insensitive)
                        const pickUpOption = Array.from(document.querySelectorAll('input[name=shipping_method]')).find(el => el.nextSibling.textContent.trim().toLowerCase().includes('pick-up'));
                        return pickUpOption && pickUpOption.checked;
                    }
                }
            }
        </script>
        
    </body>
</html>
