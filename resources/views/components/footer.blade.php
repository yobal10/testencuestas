<footer class="w-full border-t border-gray-200 dark:border-gray-700 transition-colors duration-100">
    <div class="mx-auto w-full max-w-7xl px-6 pt-12 lg:px-8">

        <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6" wire:navigate>
                    <span class="font-bold text-lg text-foreground">{{ $siteSettings['site_name'] ?? config('app.name') }}</span>
                </a>

                <p class="text-muted-foreground mb-6 max-w-md">
                    Plataforma líder de encuestas electorales en el Perú.
                </p>

                <div class="space-y-3 text-sm text-muted-foreground">

                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $siteSettings['email'] ?? 'correo@gmail.com' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ $siteSettings['phone'] ?? '+51 123 456 789'}}</span>
                    </div>
                </div>
            </div>

            {{-- Sobre Nosotros --}}
            <div>
                <h3 class="font-semibold text-foreground mb-4">Sobre Nosotros</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('about') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>Sobre Nosotros</a></li>
                    <li><a href="{{ route('how-it-works') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>Cómo Funciona</a></li>
                    {{-- <li><a href="{{ route('contact') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>Contacto</a></li> --}}
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h3 class="font-semibold text-foreground mb-4">Legal</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('consent-terms') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>Términos y Condiciones</a></li>
                    <li><a href="{{ route('privacy-policy') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>Política de Privacidad</a></li>
                    <li><button type="button" onclick="showHideToggleCookiePreferencesModal()" class="cursor-pointer text-muted-foreground hover:text-primary transition-colors">Cookies</button></li>
                </ul>
            </div>

        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-200 dark:border-gray-700 my-5"></div>

        {{-- Bottom --}}
        <div class="mb-5 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

            <p class="text-sm text-muted-foreground text-center sm:text-left">
                © {{ \Carbon\Carbon::now()->format('Y') }} {{ $siteSettings['site_name'] ?? config('app.name') }}. Todos los derechos reservados.
            </p>

            <div class="flex items-center justify-center gap-4">
                @php $socialLinks = [
                    ['name' => 'Facebook', 'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z', 'href' => $siteSettings['facebook'] ?? '#'],
                    ['name' => 'Twitter', 'icon' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z', 'href' => $siteSettings['twitter'] ?? '#'],
                    ['name' => 'Instagram', 'icon' => 'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M6.5 6.5h11v11h-11z M7.5 2h9a5.5 5.5 0 015.5 5.5v9a5.5 5.5 0 01-5.5 5.5h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2z', 'href' => $siteSettings['instagram'] ?? '#'],
                ];
                @endphp

                @foreach($socialLinks as $social)
                    <a href="{{ $social['href'] }}"
                       class="w-10 h-10 rounded-lg bg-muted flex items-center justify-center text-muted-foreground hover:bg-primary hover:text-primary-foreground transition-all hover:scale-110 hover:-translate-y-1"
                       aria-label="{{ $social['name'] }}"
                       target="_blank">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $social['icon'] }}"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
