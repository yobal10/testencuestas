<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title . ' - ' . $siteSettings['site_name'] }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-white text-zinc-800 dark:bg-zinc-900 dark:text-zinc-200">

    {{-- HEADER --}}
    <header class="bg-linear-to-r from-red-700 to-red-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-lg md:text-xl font-bold tracking-wide" wire:navigate>
                {{ $siteSettings['site_name'] }}
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('privacy-policy') }}" class="hover:opacity-80 transition" wire:navigate>Privacidad</a>
                <a href="{{ route('consent-terms') }}" class="hover:opacity-80 transition" wire:navigate>Términos</a>
            </nav>
        </div>
    </header>

    {{-- CONTENIDO --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto px-6 py-12">
            <h1 class="text-3xl md:text-4xl font-bold mb-8 text-red-700 dark:text-red-500">
                {{ $title }}
            </h1>

            <div class="prose prose-zinc dark:prose-invert max-w-none prose-headings:scroll-mt-24">
                {{ $slot }}
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-zinc-100 dark:bg-zinc-950 border-t border-zinc-200 dark:border-zinc-800 mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-sm text-zinc-600 dark:text-zinc-400 flex flex-col md:flex-row justify-between gap-4">
            <p>© {{ date('Y') }} {{ $siteSettings['site_name'] }}. Todos los derechos reservados.</p>
            <div class="flex gap-4">
                <a href="{{ route('privacy-policy') }}" class="hover:text-red-600" wire:navigate>Política de Privacidad</a>
                <a href="{{ route('consent-terms') }}" class="hover:text-red-600" wire:navigate>Términos y Condiciones</a>
            </div>
        </div>
    </footer>

</body>
</html>
