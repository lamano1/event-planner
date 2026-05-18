<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EventPlan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen animated-bg">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 border-b border-purple-500 border-opacity-30">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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
            <div x-data="{ show: true }" x-init="setTimeout(()=> show=false, 4000)" x-show="show" class="fixed bottom-6 right-6 max-w-sm w-full z-50">
                <div class="p-4 rounded-lg card-glow backdrop-blur-md">
                    @if(session('success'))
                        <div class="text-sm text-green-400 glow-green">✓ {{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="text-sm text-red-400">✕ {{ session('error') }}</div>
                    @endif
                </div>
            </div>
        @endif
    </body>
</html>