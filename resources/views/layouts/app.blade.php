<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/x-icon" href="/assets/images/favicon.png">
        <!-- Styles -->
        @stack('style')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @livewireStyles
        <!-- Scripts -->
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray">
            @include('layouts.header')
            @include('layouts.sidebar')
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
         <!-- Scripts -->
        <script>
            window.CURRENT_USER_ID = {{ auth()->id() ?? '0' }};
        </script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/fa593b9092.js" crossorigin="anonymous"></script>
        @livewireScripts
        @stack('script')
    </body>

</html>
