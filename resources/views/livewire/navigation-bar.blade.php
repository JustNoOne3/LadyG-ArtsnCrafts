<header class="z-50 sticky top-0 left-0 w-full bg-[#f8f8f8] ">
    <div class="mx-auto w-full px-4 sm:px-8 lg:px-16">
        <!-- Responsive header: logo left, login/cart right on mobile -->
        <div class="flex h-24 justify-between md:justify-end items-center font-poppins gap-4 md:gap-12 border-b-2 rounded border-[#EBAE6E]">
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
                        <a class="text-[#8c370f] hover:text-[#BA4B18] transition" href="#About"> About Us </a>
                    </li>
                    <li>
                        <a class="text-[#8c370f]"> | </a>
                    </li>
                    <li>
                        <a class="text-[#8c370f] hover:text-[#BA4B18] transition" href="#Partners"> Log in or Create an Account </a>
                    </li>
                </ul>
            </div>
            <!-- Mobile nav: login & cart right -->
            <div class="flex items-center gap-2 md:hidden">
                <a class="text-[#8c370f] text-sm px-2 py-1 rounded hover:text-[#BA4B18]" href="#Partners">Login</a>
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
        <style>
        @media (max-width: 767px) {
            .carousel-viewport {
                width: 100%;
                overflow: hidden;
                position: relative;
            }
            .carousel-row {
                display: flex;
                gap: 1rem;
                will-change: transform;
                transition: none;
            }
            .brand-carousel-item {
                flex: 0 0 33.33%;
                max-width: 33.33%;
                box-sizing: border-box;
                display: flex;
                justify-content: center;
                align-items: center;
                border: none !important;
            }
            .brand-carousel-item img {
                border-bottom: none !important;
                box-shadow: none !important;
            }
        }
        </style>
        <div class="min-h-24 md:min-h-36 p-4 w-full flex justify-center">
            <div x-data="{ activeIdx: null }" class="w-full flex flex-col justify-center">
                <!-- Mobile 2-row carousel -->
                <div class="w-full md:hidden space-y-2">
                    @php
                        $brands = App\Models\Brand::select('id', 'brand_logo', 'brand_name')->get();
                        $brandsReversed = $brands->reverse()->values();
                    @endphp
                    <div class="carousel-viewport" x-data="carouselTranslateRight({ speed: 1 })" x-init="start()">
                        <div class="carousel-row" :style="`transform: translateX(${translate}px)`" x-ref="row">
                            @foreach($brands as $brand)
                                <div class="brand-carousel-item">
                                    <img 
                                        src="{{ asset('storage/' . $brand->brand_logo) }}" 
                                        alt="{{ $brand->brand_name }} Logo" 
                                        class="h-20 w-auto object-contain max-w-[100px] transition-transform duration-300 ease-in-out hover:scale-125 box-border"
                                        style="max-width: 100%; min-width: 0;"
                                    >
                                </div>
                            @endforeach
                            @foreach($brands as $brand)
                                <div class="brand-carousel-item">
                                    <img 
                                        src="{{ asset('storage/' . $brand->brand_logo) }}" 
                                        alt="{{ $brand->brand_name }} Logo" 
                                        class="h-20 w-auto object-contain max-w-[100px] transition-transform duration-300 ease-in-out hover:scale-125 box-border"
                                        style="max-width: 100%; min-width: 0;"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <script>
                        function carouselTranslateRight({ speed }) {
                            return {
                                translate: 0,
                                start() {
                                    const row = this.$refs.row;
                                    if (!row) return;
                                    const item = row.querySelector('.brand-carousel-item');
                                    if (!item) return;
                                    const itemWidth = item.offsetWidth + parseFloat(getComputedStyle(row).gap || 0);
                                    const total = itemWidth * (row.children.length / 2);
                                    let pos = 0;
                                    const step = () => {
                                        pos += 1 * speed;
                                        if (pos >= total) pos = 0;
                                        if (pos <= -total) pos = 0;
                                        this.translate = -pos;
                                        requestAnimationFrame(step);
                                    };
                                    requestAnimationFrame(step);
                                }
                            }
                        }
                    </script>
                <div class="w-full overflow-x-auto md:overflow-x-visible scrollbar-thin scrollbar-thumb-[#D19658] scrollbar-track-[#f8f8f8] hidden md:block">
                    <div
                        class="grid grid-cols-3 grid-rows-3 md:grid-cols-5 md:grid-rows-auto gap-4 items-center justify-center max-w-full lg:flex lg:flex-row lg:items-center lg:gap-2 lg:overflow-x-visible p-4"
                        style="min-width: 0;"
                    >
                        @foreach($brands as $idx => $brand)
                            <div class="flex block justify-center items-center min-w-0" @click="activeIdx = {{ $idx }}">
                                <img 
                                    src="{{ asset('storage/' . $brand->brand_logo) }}" 
                                    alt="{{ $brand->brand_name }} Logo" 
                                    :class="activeIdx === {{ $idx }} ? 'border-2 rounded-xl border-[#8c370f] rounded-full' : ''"
                                    class="h-20 w-auto object-contain max-w-[100px] lg:h-32 md:max-w-[120px] transition-transform duration-300 ease-in-out hover:scale-125 box-border"
                                    style="max-width: 100%; min-width: 0;"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>