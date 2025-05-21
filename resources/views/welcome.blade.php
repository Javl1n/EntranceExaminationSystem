<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('image/SLSPI-LOGO.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-blue-500 selection:text-white gap-5">
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
            <x-application-logo class="w-72 fill-blue-500"/>
            <div>
                {{-- <h1 class="text-4xl">Junior and Senior High School</h1> --}}
                <h1 class="text-4xl">Web Based High School</h1>
                <h1 class="text-6xl mb-5">Entrance Examination</h1>
                @guest
                    <a href="{{ route('examinees.create') }}" wire:navigate class="transition ease-in-out duration-300 px-6 py-2 mt-5 bg-blue-600 hover:bg-blue-900 text-white font-bold rounded">Get Started</a>
                @endguest
            </div>
        </div>
    </body>
</html>
