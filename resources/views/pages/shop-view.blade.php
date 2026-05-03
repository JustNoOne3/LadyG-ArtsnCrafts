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
        {{-- Navigation --}}
        <div id="nav-sticky-wrapper" style="position:relative; z-index:50;">
            <div id="nav-sticky-inner" style="position:sticky; top:0; z-index:50;">
                @livewire('compressed-navigation')
            </div>
        </div>
        <div id="loadingScreen" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FAF5F0] transition-opacity duration-700 h-screen w-screen">
            <div class="flex flex-col justify-center items-center w-full h-full">
                <x-lottie path="{{asset('animations/LadyG.json')}}" loop="true" autoplay="true" class="mx-auto w-auto h-96" />
            </div>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                // Always scroll to top on page load
                window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
                // Remove focus from any element
                if(document.activeElement) document.activeElement.blur();
                setTimeout(function() {
                    const loading = document.getElementById('loadingScreen');
                    loading.classList.add('opacity-0');
                    setTimeout(() => loading.style.display = 'none', 700);
                }, 4500);
            });
        </script>
        {{-- Breadcrumbs --}}
        <div class="w-full h-10 md:h-14 bg-[#e6d9cb] px-2 lg:px-40 flex gap-2 md:gap-4 text-[#7a4025] text-sm md:text-md items-start md:items-center">
            <a class="hover:underline" href="/"> Home </a>
            >
            <a class="hover:underline" href="Home">Brand Name</a>
        </div>
        <!-- Vue Brand Section -->
        <div id="brand-section-app" data-brand-id="{{ $id }}"></div>
        {{-- Footer --}}
        @livewire('footer-section')
    </body>
