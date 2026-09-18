<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        @php
            $metaTitle = $title ?? $siteSettings['site_name'] ?? config('app.name');
            $metaDescription = $description ?? $siteSettings['description'] ?? 'Bienvenido a ' . config('app.name') . ', tu plataforma de encuestas en línea.';
            $metaImage = $image ?? asset('images/website/image_site_default.png');
            $metaUrl = $url ?? url()->current();
        @endphp

        <title>{{ $metaTitle }}</title>

        <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? config('app.name') }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:image" content="{{ $metaImage }}">
        <meta property="og:url" content="{{ $metaUrl }}">
        <meta property="og:type" content="article">
        <meta property="og:locale" content="es_PE">

        <meta name="description" content="{{ $metaDescription }}">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ $metaUrl }}">
        <meta name="author" content="{{ $siteSettings['site_name'] ?? config('app.name') }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        <meta name="twitter:image" content="{{ $metaImage }}">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">


        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @fluxAppearance

        {!! CookieConsent::styles() !!}
    </head>
    <body class="min-h-screen flex flex-col bg-white dark:bg-zinc-800">

        <x-navbar />

        <div class="flex-1 w-full">
            {{ $slot }}
        </div>

        <x-footer />

        @fluxScripts

        @persist('toast')
            <flux:toast />
        @endpersist

        {!! CookieConsent::scripts() !!}

        {{-- Scripts --}}
        @stack('scripts')
    </body>
</html>
