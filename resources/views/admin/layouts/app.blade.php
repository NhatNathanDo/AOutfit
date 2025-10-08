<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: localStorage.getItem('theme') || 'light', toggle(){ this.theme = this.theme==='light' ? 'dark' : 'light'; localStorage.setItem('theme', this.theme); document.documentElement.dataset.theme = this.theme; } }" x-init="document.documentElement.dataset.theme = theme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="color-scheme" content="light dark">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <livewire:styles />
    </head>
    <body class="min-h-screen flex flex-col bg-base-200 text-base-content selection:bg-primary/30 selection:text-primary-content">
        <div x-cloak class="fixed top-0 left-0 h-0.5 w-full bg-gradient-to-r from-primary via-secondary to-accent opacity-0" x-show="$store?.loading?.active"></div>
        <main class="flex-1">@yield('content')</main>
        <footer class="py-4 text-center text-xs opacity-60">© {{ date('Y') }} AOutfit Admin</footer>
        <livewire:scripts />
    </body>
</html>