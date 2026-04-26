<div>
    <div class="flex gap-2 mb-2">
        <select wire:model="variantId" class="rounded border-gray-300 px-2 py-1">
            <option value="">Select Variant</option>
            @foreach($variants ?? [] as $variant)
                <option value="{{ $variant->id }}">{{ $variant->variant_name }}</option>
            @endforeach
        </select>
        <select wire:model="subvariantId" class="rounded border-gray-300 px-2 py-1">
            <option value="">Select Subvariant</option>
            @foreach($subvariants ?? [] as $subvariant)
                <option value="{{ $subvariant->id }}">{{ $subvariant->subvar_name }}</option>
            @endforeach
        </select>
        <input type="number" min="1" wire:model="quantity" class="w-20 rounded border-gray-300 px-2 py-1" />
    </div>
    <button wire:click.prevent="addToCart" class="flex items-center gap-4 px-6 py-3 rounded-lg shadow-lg bg-[#8c370f] text-white font-semibold text-sm md:text-lg hover:bg-[#63321c] transition">
        <x-bi-cart3 class="hidden md:block w-6 h-6 text-white " />
        Add to Cart
    </button>

    @if($showSuccessModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
                <h2 class="text-2xl font-bold mb-4 text-[#7a4025]">Successfully added to cart</h2>
                <button wire:click="closeModal" class="bg-[#7a4025] text-white px-6 py-2 rounded hover:bg-[#63321c] font-semibold w-full mt-4">Close</button>
            </div>
        </div>
    @endif
</div>
