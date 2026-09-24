<div class="w-full">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex items-center">
        <flux:sidebar.toggle class="md:hidden" icon="bars-2" inset="left" />

        <flux:brand href="{{ route('home') }}" name="{{ $siteSettings['site_name'] ?? config('app.name') }}" class="max-md:hidden font-bold" wire:navigate />

        <flux:spacer />

        <flux:sidebar.nav variant="outline">
    <flux:sidebar.group>

        <flux:sidebar.item
            icon="house"
            href="{{ route('home') }}"
            :current="request()->routeIs('home')"
        >
            Inicio
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="clipboard-plus"
            href="{{ route('polls') }}"
            :current="request()->routeIs('polls', 'polls.*')"
        >
            Encuestas
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="users"
            href="{{ route('community') }}"
            :current="request()->routeIs('community')"
        >
            Comunidad académica
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="academic-cap"
            href="{{ route('about') }}"
            :current="request()->routeIs('about')"
        >
            Universidad
        </flux:sidebar.item>

    </flux:sidebar.group>
</flux:sidebar.nav>

        <flux:spacer />

        <flux:navbar>
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" size="sm" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            <flux:spacer />
        </flux:navbar>
    </flux:header>

    <flux:sidebar collapsible="mobile" sticky class="md:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <flux:sidebar.collapse class="md:hidden" />
        </flux:sidebar.header>
q222222222
        <flux:sidebar.nav variant="outline">
    <flux:sidebar.group>

        <flux:sidebar.item
            icon="house"
            href="{{ route('home') }}"
            :current="request()->routeIs('home')"
        >
            Inicio
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="clipboard-plus"
            href="{{ route('polls') }}"
            :current="request()->routeIs('polls', 'polls.*')"
        >
            Encuestas
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="users"
            href="{{ route('community') }}"
            :current="request()->routeIs('community')"
        >
            Comunidad académica
        </flux:sidebar.item>

        <flux:sidebar.item
            icon="academic-cap"
            href="{{ route('about') }}"
            :current="request()->routeIs('about')"
        >
            Universidad
        </flux:sidebar.item>

    </flux:sidebar.group>
</flux:sidebar.nav>
    </flux:sidebar>
</div>
