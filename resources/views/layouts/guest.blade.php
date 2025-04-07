<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-4">
                <a href="/" class="flex items-center justify-center">
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
                </a>
            </div>

            <div class="w-full sm:max-w-md">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </body>
</html>
