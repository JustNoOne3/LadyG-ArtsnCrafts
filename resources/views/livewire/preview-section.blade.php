<div class="w-full h-96 bg-[#e6d9cb] grid grid-cols-1 md:grid-cols-2 relative" wire:poll.10s="switchCategory" style="font-family: 'Poppins', sans-serif;">
    <div class="flex flex-col justify-between items-center h-full relative p-4 min-h-0">
        <div class="w-full grid grid-cols-3 md:grid-cols-4 justify-center items-center px-2 md:px-8 pt-0 md:pt-2 md:mb-8 h-full">
            @foreach($leftProducts as $i => $product)
                @if($i < 3 || (request()->isNotFilled('mobile') && $i < 4))
                <div class="flex flex-col items-start {{ $i >= 3 ? 'hidden md:flex' : '' }}">
                    <img src="{{ asset('storage/' . $product->product_thumbnail) }}" alt="{{ $product->product_name }}" class="w-58 h-28 md:h-48 object-cover bg-[#E6DFD8] rounded shadow-md md:mb-1">
                    <span class="hidden md:block font-semibold text-[#7a4025] text-left">{{ $product->product_name }}</span>
                    {{-- <span class="hidden md:block text-xs text-[#7a4025] text-left">Price: ₱{{ number_format($product->product_price, 2) }}</span> --}}
                </div>
                @endif
            @endforeach
        </div>
        <div class="flex flex-col gap-0 md:absolute md:left-4 md:bottom-2 mt-2 md:mt-0">
            <span class="text-lg font-bold text-[#7a4025] text-center md:text-left uppercase">{{ $leftBrand->brand_name ?? '' }}</span>
            <span class="text-lg text-[#b27b41] text-center md:text-left -mt-2">Best Sellers</span>
        </div>
    </div>
    <div class="hidden md:block absolute top-6 bottom-6 left-1/2 -translate-x-1/2 w-0.5">
        <div class="h-full border-r-2 border-[#7a4025]/25"></div>
    </div>
    <div class="flex flex-col justify-between items-center h-full relative p-4 min-h-0">
        <div class="w-full grid grid-cols-3 md:grid-cols-4 justify-center items-center pl-2 md:pl-12 pt-0 md:pt-2 md:mb-8 h-full">
            @foreach($rightProducts as $i => $product)
                @if($i < 3 || (request()->isNotFilled('mobile') && $i < 4))
                <div class="flex flex-col items-start {{ $i >= 3 ? 'hidden md:flex' : '' }}">
                    <img src="{{ asset('storage/' . $product->product_thumbnail) }}" alt="{{ $product->product_name }}" class="w-58 h-28 md:h-48 object-cover bg-[#E6DFD8] rounded shadow-md md:mb-1">
                    <span class="hidden md:block font-semibold text-[#7a4025] text-left">{{ $product->product_name }}</span>
                    {{-- <span class="hidden md:block text-xs text-[#7a4025] text-left">Price: ₱{{ number_format($product->product_price, 2) }}</span> --}}
                </div>
                @endif
            @endforeach
        </div>
        <div class="flex flex-col gap-0 md:absolute md:right-4 md:bottom-2 mt-2 md:mt-0">
            <span class="text-lg font-bold text-[#7a4025] text-center md:text-right uppercase">{{ $rightBrand->brand_name ?? '' }}</span>
            <span class="text-lg text-[#b27b41] text-center md:text-right -mt-2">Top picks</span>
        </div>
    </div>
</div>