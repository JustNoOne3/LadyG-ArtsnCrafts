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
            <a class="hover:underline" href="Home">Brand Name</a>
            >
            <a class="hover:underline" href="Home">Category Name</a>
        </div>
        <div class="min-h-screen bg-[#FAF5F0] py-0 md:py-12 font-poppins" >
            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row gap-8">
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-80 h-80 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <img id="main-image" src="{{ $mainImage }}" alt="{{ $product->product_name }}" class="object-contain max-h-72 max-w-full rounded">
                    </div>
                    <div class="flex gap-2 mt-2">
                        @foreach($images as $img)
                            <img src="{{ $img }}" alt="{{ $product->product_name }}" class="w-16 h-16 object-cover rounded border-2 border-transparent hover:border-[#8c370f] cursor-pointer" onclick="document.getElementById('main-image').src='{{ $img }}'">
                        @endforeach
                    </div>
                </div>
                <div class="flex-1 flex flex-col " autofocus>
                    <h1 class="text-2xl font-bold text-[#8c370f]">{{ $product->product_name }}</h1>
                    <div class="text-lg text-gray-700">{{ $product->product_description }}</div>
                    <div class="flex items-center gap-1 mt-2">
                        @php $rating = (int)($product->product_rating ?? 0); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating)
                                <svg class="w-5 h-5 text-yellow-400 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                            @endif
                        @endfor
                        <span class="ml-2 text-sm text-gray-500">({{ $product->product_rating ?? 0 }})</span>
                    </div>
                    <div class="text-2xl mt-10 font-semibold text-[#8c370f]" id="dynamic-price">₱{{ number_format($product->product_price, 2) }}</div>
                    <div class="text-sm text-gray-500">Sold: {{ $product->product_soldCount }}</div>

                    {{-- Variant Selection --}}
                    @if($variants->count())
                    <div class="mt-4">
                        <div class="font-semibold mb-2">Select Variant:</div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($variants as $variant)
                                <button type="button" class="variant-btn border-2 border-transparent rounded-lg p-1 hover:border-[#8c370f] focus:border-[#8c370f] focus:outline-none"
                                    style="background: #f7ede3;"
                                    onclick="selectVariant({{ $variant->id }})"
                                    id="variant-btn-{{ $variant->id }}">
                                    <img src="{{ asset('storage/' . $variant->variant_image) }}" alt="{{ $variant->variant_name }}" class="w-12 h-12 object-cover rounded mb-1">
                                    <div class="text-xs text-[#8c370f]">{{ $variant->variant_name }}</div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Subvariant Selection --}}
                    <div class="mt-4" id="subvariant-section" style="display:none;">
                        <div class="font-semibold mb-2">Select Sub Variant:</div>
                        <div class="flex gap-2 flex-wrap" id="subvariant-btns">
                            {{-- Subvariant buttons will be injected by JS --}}
                        </div>
                    </div>

                    {{-- Quantity Selector --}}
                    <div class="mt-4 flex items-center gap-2">
                        <span class="font-semibold">Quantity:</span>
                        <input type="number" id="order-qty" min="1" value="1" class="w-20 rounded border-gray-300 px-2 py-1">
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button id="add-to-cart-btn" type="button" class="flex items-center gap-4 px-6 py-3 rounded-lg shadow-lg bg-[#8c370f] text-white font-semibold text-sm md:text-lg hover:bg-[#63321c] transition" disabled>
                            <x-bi-cart3 class="hidden md:block w-6 h-6 text-white " />
                            Add to Cart
                        </button>
                        <!-- Success Modal -->
                        <div id="cart-success-modal" style="display:none;" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full text-center">
                                <h2 class="text-2xl font-bold mb-4 text-[#7a4025]">Successfully added to cart!</h2>
                                <button onclick="location.reload()" class="bg-[#7a4025] text-white px-6 py-2 rounded hover:bg-[#63321c] font-semibold w-full mt-4">Continue Shopping</button>
                            </div>
                        </div>
                        <button class="flex items-center gap-4 px-6 py-3 rounded-lg shadow-lg border-2 border-[#7a4025] text-[#7a4025] font-semibold text-sm md:text-lg hover:bg-[#63321c] transition">
                            <x-bi-bag-check class="hidden md:block w-6 h-6 text-[#7a4025]" />
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
    </body>
</html>

<script>
    // Variant and subvariant logic
    const variants = @json($variants);
    const subvariants = @json($subvariants);
    let selectedVariantId = null;
    let selectedSubvariantId = null;

    function updateAddToCartButton() {
        const btn = document.getElementById('add-to-cart-btn');
        // If there are subvariants for the selected variant, require both to be selected
        if (selectedVariantId) {
            const hasSubvariants = subvariants.some(sv => sv.subvar_variantId == selectedVariantId);
            if (hasSubvariants) {
                btn.disabled = !selectedSubvariantId;
            } else {
                btn.disabled = false;
            }
        } else {
            btn.disabled = true;
        }
    }

    // Add to Cart AJAX logic
    document.addEventListener('DOMContentLoaded', function() {
        updateAddToCartButton();
        document.getElementById('add-to-cart-btn').addEventListener('click', function() {
            const productId = {{ $product->id }};
            const variantId = selectedVariantId;
            const subvariantId = selectedSubvariantId;
            const quantity = parseInt(document.getElementById('order-qty').value) || 1;

            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    variant_id: variantId,
                    subvariant_id: subvariantId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-success-modal').style.display = 'flex';
                    // Optionally, trigger a Livewire event or JS to update cart badge
                } else {
                    alert(data.error || 'Failed to add to cart.');
                }
            })
            .catch(() => alert('Failed to add to cart.'));
        });
    });

    function selectVariant(variantId) {
        selectedVariantId = variantId;
        selectedSubvariantId = null; // reset subvariant selection on variant change
        // Highlight selected variant
        document.querySelectorAll('.variant-btn').forEach(btn => btn.classList.remove('border-[#8c370f]', 'border-2'));
        const btn = document.getElementById('variant-btn-' + variantId);
        if (btn) btn.classList.add('border-[#8c370f]', 'border-2');

        // Update price
        const variant = variants.find(v => v.id == variantId);
        if (variant && variant.variant_price) {
            document.getElementById('dynamic-price').innerText = '₱' + Number(variant.variant_price).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        } else {
            document.getElementById('dynamic-price').innerText = '₱' + Number(@json($product->product_price)).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        }

        // Show subvariants for this variant
        const subvarSection = document.getElementById('subvariant-section');
        const subvarBtns = document.getElementById('subvariant-btns');
        subvarBtns.innerHTML = '';
        const filtered = subvariants.filter(sv => sv.subvar_variantId == variantId);
        if (filtered.length) {
            subvarSection.style.display = '';
            filtered.forEach(subvar => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'subvariant-btn border-2 border-transparent rounded-lg p-1 hover:border-[#8c370f] focus:border-[#8c370f] focus:outline-none';
                btn.style.background = '#f7ede3';
                btn.onclick = () => selectSubvariant(subvar.id);
                btn.id = 'subvariant-btn-' + subvar.id;
                btn.innerHTML = `<img src='${subvar.subvar_image ? '/storage/' + subvar.subvar_image : ''}' alt='${subvar.subvar_name}' class='w-12 h-12 object-cover rounded mb-1'><div class='text-xs text-[#8c370f]'>${subvar.subvar_name}</div>`;
                subvarBtns.appendChild(btn);
            });
        } else {
            subvarSection.style.display = 'none';
        }
        // Keep variant border if subvariant is selected
        if (selectedSubvariantId) {
            const vbtn = document.getElementById('variant-btn-' + variantId);
            if (vbtn) vbtn.classList.add('border-[#8c370f]', 'border-2');
        }
        updateAddToCartButton();
    }
    function selectSubvariant(subvarId) {
        selectedSubvariantId = subvarId;
        // Keep variant border
        if (selectedVariantId) {
            const vbtn = document.getElementById('variant-btn-' + selectedVariantId);
            if (vbtn) vbtn.classList.add('border-[#8c370f]', 'border-2');
        }
        document.querySelectorAll('.subvariant-btn').forEach(btn => btn.classList.remove('border-[#8c370f]', 'border-2'));
        const btn = document.getElementById('subvariant-btn-' + subvarId);
        if (btn) btn.classList.add('border-[#8c370f]', 'border-2');
        // Update price
        const subvar = subvariants.find(sv => sv.id == subvarId);
        if (subvar && subvar.subvar_price) {
            document.getElementById('dynamic-price').innerText = '₱' + Number(subvar.subvar_price).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        }
        updateAddToCartButton();
    }
</script>
