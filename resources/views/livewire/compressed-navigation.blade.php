<header class="z-50 sticky top-0 left-0 w-full bg-[#f8f8f8] ">
    <div class="mx-auto w-full px-4 sm:px-8 lg:px-16">
        <!-- Responsive header: logo left, login/cart right on mobile -->
        <div class="flex h-20 md:h-24 justify-between md:justify-end items-center font-poppins gap-4 md:gap-12 md:border-b-2 md:rounded md:border-[#EBAE6E]">
            <div class="flex items-center flex-shrink-0">
                <!-- WEB APP Logo -->
                <a class="block text-teal-600" href="/">
                    <span class="sr-only">Home</span>
                    <img src="{{asset('images/ladyg_logo.png')}}" alt="PFDA Logo" class="rounded-full h-20 w-auto md:h-36">
                </a>
            </div>
            <!-- Desktop nav -->
            <div class="hidden md:block">
                <ul class="flex items-center gap-6 text-lg justify-center">
                    <li>
                        <a class="text-[#8c370f] hover:text-[#BA4B18] transition" href="/about-us"> About Us </a>
                    </li>
                    <li>
                        <a class="text-[#8c370f]"> | </a>
                    </li>
                    <li>
                        @if(auth()->user())
                            @livewire('logout-modal')
                        @else
                            <a class="text-[#8c370f] hover:text-[#BA4B18] transition" href="/login">Log in or Create an Account  </a>
                        @endif
                    </li>
                    
                </ul>
            </div>
            <!-- Mobile nav: login & cart right -->
            <div class="flex items-center gap-2 md:hidden">
                @if(auth()->user())
                    @livewire('logout-modal')
                @else
                    <a class="text-[#8c370f] text-sm px-2 py-1 rounded hover:text-[#BA4B18]" href="#Partners">Login</a>
                @endif
                <a class="block text-teal-600" href="#">
                    <x-bi-cart3 class="w-8 h-8 text-[#8c370f] hover:text-[#BA4B18]" />
                </a>
            </div>
            <!-- Desktop cart -->
            <div class="hidden md:flex items-center">
                <a class="block text-teal-600" href="#">
                    <x-bi-cart3 class="w-12 h-12 text-[#8c370f] hover:text-[#BA4B18]" />
                </a>
            </div>
        </div>
        <div class="hidden md:block min-h-36 p-4 w-full flex justify-center">
            <div 
                x-data="{ activeIdx: null }"
                class="w-full flex justify-center"
            >
                <div
                    class="w-full overflow-x-auto md:overflow-x-visible scrollbar-thin scrollbar-thumb-[#D19658] scrollbar-track-[#f8f8f8]"
                >
                    <div
                        class="grid grid-cols-3 grid-rows-3 md:grid-cols-5 md:grid-rows-auto gap-4 items-center justify-center max-w-full lg:flex lg:flex-row lg:items-center lg:gap-2 lg:overflow-x-visible p-4"
                        style="min-width: 0;"
                    >
                        @php
                            $currentBrandId = request()->routeIs('shop.view') ? request()->route('id') : null;
                        @endphp
                        @foreach(App\Models\Brand::select('id', 'brand_logo')->get() as $idx => $brand)
                            <div class="flex block justify-center items-center min-w-0">
                                <a href="{{ route('shop.view', ['id' => $brand->id]) }}" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                                    <img 
                                        src="{{ asset('storage/' . $brand->brand_logo) }}" 
                                        alt="{{ $brand->brand_name }} Logo" 
                                        class="h-20 w-auto object-contain max-w-[100px] lg:h-32 md:max-w-[120px] transition-transform duration-300 ease-in-out hover:scale-125 box-border {{ (string)$brand->id === (string)$currentBrandId ? 'border-2 rounded-xl border-[#8c370f] rounded-full' : '' }}"
                                        style="max-width: 100%; min-width: 0;"
                                    >
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

