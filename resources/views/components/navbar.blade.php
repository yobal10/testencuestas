<div class="w-full">
    <div class="sticky top-0 z-50 w-full">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex items-center">
        <flux:sidebar.toggle class="md:hidden" icon="bars-2" inset="left" />

        <flux:brand href="{{ route('home') }}" name="{{ $siteSettings['site_name'] ?? config('app.name') }}" class="max-md:hidden font-bold" wire:navigate />

        <flux:spacer />
        <nav class="hidden items-center gap-1 md:flex" aria-label="Navegación principal">
            <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-white text-blue-600 shadow-sm dark:bg-zinc-800' : 'text-slate-600 hover:bg-white hover:text-blue-600 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                <flux:icon.house class="size-4" />
                Inicio
            </a>
            <a href="{{ route('polls') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('polls', 'polls.*') ? 'bg-white text-blue-600 shadow-sm dark:bg-zinc-800' : 'text-slate-600 hover:bg-white hover:text-blue-600 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                <flux:icon.clipboard-plus class="size-4" />
                Encuestas
            </a>
            <a href="{{ route('community') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('community') ? 'bg-white text-blue-600 shadow-sm dark:bg-zinc-800' : 'text-slate-600 hover:bg-white hover:text-blue-600 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                <flux:icon.users class="size-4" />
                Comunidad académica
            </a>
            <a href="{{ route('about') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition {{ request()->routeIs('about') ? 'bg-white text-blue-600 shadow-sm dark:bg-zinc-800' : 'text-slate-600 hover:bg-white hover:text-blue-600 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                <flux:icon.academic-cap class="size-4" />
                Universidad
            </a>
        </nav>

        <flux:spacer />

        <flux:navbar>
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" size="sm" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            <flux:spacer />
        </flux:navbar>
    </flux:header>
    </div>

    <flux:sidebar collapsible="mobile" sticky class="md:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <flux:sidebar.collapse class="md:hidden" />
        </flux:sidebar.header>
        <flux:sidebar.nav variant="outline">
            <flux:sidebar.group>
                <flux:sidebar.item icon="house" href="{{ route('home') }}" :current="request()->routeIs('home')" wire:navigate>
                    Inicio
                </flux:sidebar.item>
                <flux:sidebar.item icon="clipboard-plus" href="{{ route('polls') }}" :current="request()->routeIs('polls', 'polls.*')" wire:navigate>
                    Encuestas
                </flux:sidebar.item>
                <flux:sidebar.item icon="users" href="{{ route('community') }}" :current="request()->routeIs('community')" wire:navigate>
                    Comunidad académica
                </flux:sidebar.item>
                <flux:sidebar.item icon="academic-cap" href="{{ route('about') }}" :current="request()->routeIs('about')" wire:navigate>
                    Universidad
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>
    </flux:sidebar>
</div>
