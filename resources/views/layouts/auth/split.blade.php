<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-100 antialiased dark:bg-slate-950">
        <div class="relative grid h-dvh flex-col items-center justify-center px-4 sm:px-0 lg:max-w-none lg:grid-cols-[1.15fr_0.85fr] lg:px-0">
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[420px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>

                        <span class="sr-only">{{  $siteSettings['site_name'] ?? config('app.name') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
            <div class="relative hidden h-full flex-col overflow-hidden p-10 text-white lg:flex">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.35),transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.28),transparent_30%),linear-gradient(135deg,#0f172a_0%,#111827_35%,#1d4ed8_100%)]"></div>
                <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 28px 28px;"></div>
                <div class="relative z-10 flex h-full flex-col justify-between">
                    <a href="{{ route('home') }}" class="flex items-center text-lg font-semibold" wire:navigate>
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur-sm ring-1 ring-white/20">
                            <x-app-logo-icon class="h-7 fill-current text-white" />
                        </span>
                        <span class="ms-3">{{ $siteSettings['site_name'] ?? config('app.name') }}</span>
                    </a>

                    <div class="max-w-md space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-blue-100 backdrop-blur-sm">
                            Sistema universitario
                        </div>

                        <div>
                            <h1 class="text-4xl font-black leading-tight">Conecta la comunidad académica con decisiones basadas en evidencia.</h1>
                        </div>

                        <p class="max-w-sm text-base text-slate-200">
                            Gestiona encuestas de satisfacción estudiantil, evaluación docente, servicios universitarios y mejora continua institucional desde un único ecosistema digital.
                        </p>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">98%</div>
                                <div class="mt-1 text-xs text-slate-200">Satisfacción</div>
                            </div>
                            <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">24/7</div>
                                <div class="mt-1 text-xs text-slate-200">Acceso</div>
                            </div>
                            <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">1</div>
                                <div class="mt-1 text-xs text-slate-200">Plataforma</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 text-sm text-slate-200/80">
                        © {{ date('Y') }} {{ $siteSettings['site_name'] ?? config('app.name') }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
