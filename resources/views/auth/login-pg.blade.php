    
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
                </div>
            </div>
        </header>

        <div class="w-full h-screen bg-[#e6d9cb] flex items-center justify-center">
            <div class="w-1/2 h-auto min-h-96 bg-white rounded-lg shadow-lg flex flex-col items-center justify-center p-8">
                <span class="text-2xl font-bold text-[#7a4025]">Welcome to LadyG Arts & Crafts</span>
                <span class="text-lg text-[#7a4025]">Please log in to continue</span>
                    @include('auth.partials.login-form')

            </div>
        </div>
        
        {{-- Footer --}}
        @livewire('footer-section')
        @livewireScripts
    </body>
