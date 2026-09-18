<div class="w-full">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex items-center">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:brand href="{{ route('home') }}" name="{{ $siteSettings['site_name'] }}" class="max-lg:hidden font-bold" wire:navigate />

        <flux:spacer />

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item href="{{ route('home') }}" :current="request()->routeIs('home')" wire:navigate>Inicio</flux:navbar.item>
            <flux:navbar.item href="{{ route('polls') }}" :current="request()->routeIs('polls', 'polls.*')" wire:navigate>Encuestas</flux:navbar.item>
            <flux:navbar.item href="{{ route('parties') }}" :current="request()->routeIs('parties', 'parties.*')" wire:navigate>Partidos Políticos</flux:navbar.item>
            {{-- <flux:navbar.item href="{{ route('contact') }}" :current="request()->routeIs('contact')" wire:navigate>Contacto</flux:navbar.item> --}}
        </flux:navbar>

        <flux:spacer />

        {{-- Apariencia --}}
        <flux:navbar>
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" size="sm"  icon="moon" variant="subtle" aria-label="Toggle dark mode" />

            <flux:spacer />
        </flux:navbar>
    </flux:header>

    {{-- Mobile sidebar --}}
    <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav variant="outline">
            <flux:sidebar.group>
                <flux:sidebar.item icon="house" href="{{ route('home') }}" :current="request()->routeIs('home')" wire:navigate>
                    Inicio
                </flux:sidebar.item>
                <flux:sidebar.item icon="clipboard-plus" href="{{ route('polls') }}" :current="request()->routeIs('polls', 'polls.*')" wire:navigate>
                    Encuestas
                </flux:sidebar.item>

                <flux:sidebar.item icon="warehouse" href="{{ route('parties') }}" :current="request()->routeIs('parties', 'parties.*')" wire:navigate>
                    Partidos Políticos
                </flux:sidebar.item>

                {{-- <flux:sidebar.item icon="contact" href="{{ route('contact') }}" :current="request()->routeIs('contact')" wire:navigate>
                    Contacto
                </flux:sidebar.item> --}}
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />
    </flux:sidebar>
</div>
