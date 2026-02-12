<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Web App') }}</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*  */
            </style>
        @endif
    </head>
    <body class="body">
        <header>
            @include('components.navbar')
        </header>
        <main class="flex-grow">
            @yield('content')
        </main>
        <footer class="flex justify-center mt-8">
            <!--  -->
        </footer>
    </body>
</html>
