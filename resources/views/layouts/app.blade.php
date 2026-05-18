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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Global toast notifications (uses Alpine.js) -->
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(()=> show=false, 4000)" x-show="show" class="fixed bottom-6 right-6 max-w-sm w-full">
                <div class="p-3 rounded shadow-lg bg-white border">
                    @if(session('success'))
                        <div class="text-sm text-green-700">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="text-sm text-red-700">{{ session('error') }}</div>
                    @endif
                </div>
            </div>
        @endif
    </body>
</html>
