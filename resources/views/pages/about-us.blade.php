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
    </head>
    <body class="bg-white">
        {{-- Navigation --}}
        <div id="nav-sticky-wrapper" style="position:relative; z-index:50;">
            <div id="nav-sticky-inner" style="position:sticky; top:0; z-index:50;">
                @livewire('compressed-navigation')
            </div>
        </div>
        {{-- Breadcrumbs --}}
        <div class="w-full h-10 md:h-14 bg-[#e6d9cb] px-2 lg:px-40 flex gap-2 md:gap-4 text-[#7a4025] text-sm md:text-md items-start md:items-center">
            <a class="hover:underline" href="/"> Home </a>
            >
            <a class="hover:underline" href="Home">About Us</a>
        </div>
        @livewire('aboutus-section')
        
        {{-- Footer --}}
        @livewire('footer-section')
    </body>
