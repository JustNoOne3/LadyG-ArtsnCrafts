<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lady G Online Shoppe</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
        <style>
            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }
        </style>
        @livewireStyles
        {{-- <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}" class="rounded-full"> --}}
    </head>
    <body class="bg-white">


        <div id="nav-sticky-wrapper" style="position:relative; z-index:50;">
            <div id="nav-sticky-inner" style="position:sticky; top:0; z-index:50;">
                <div class="block md:hidden">
                    @livewire('navigation-bar')
                </div>
                <div class="hidden md:block">
                    @livewire('compressed-navigation')
                </div>
            </div>
        </div>
        @livewire('preview-section')
        <div id="shop-sentinel"></div>
        <div id="shop-section-vue"></div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navWrapper = document.getElementById('nav-sticky-wrapper');
            const navInner = document.getElementById('nav-sticky-inner');
            const previewSection = document.querySelector('[wire\:poll]');
            const shopSection = document.getElementById('Shop');
            const sentinel = document.getElementById('shop-sentinel');
            if (!navWrapper || !navInner || !previewSection || !shopSection || !sentinel) return;

            // Place sentinel just before the shop section
            shopSection.parentNode.insertBefore(sentinel, shopSection);

            function getPreviewBottom() {
                const rect = previewSection.getBoundingClientRect();
                return rect.bottom + window.scrollY;
            }

            function onScroll() {
                const navHeight = navInner.offsetHeight;
                const previewBottom = getPreviewBottom();
                const scrollY = window.scrollY;
                if (scrollY + navHeight >= previewBottom) {
                    navInner.style.position = 'absolute';
                    navInner.style.top = (previewBottom - navWrapper.offsetTop - navHeight) + 'px';
                } else {
                    navInner.style.position = 'sticky';
                    navInner.style.top = '0';
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll);
            onScroll();
        });
        </script>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
