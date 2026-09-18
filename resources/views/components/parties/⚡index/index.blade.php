<div class="min-h-screen bg-white dark:bg-[#1D293D] py-16">
    <div class="container mx-auto px-4 max-w-6xl">

        <div class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Partidos Políticos
            </h1>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Conoce los partidos políticos que participan en las encuestas electorales.
            </p>
        </div>

        <div class="mb-8">
            <flux:input icon="magnifying-glass" wire:model.live.300ms="search" placeholder="Ingrese el nombre del partido político a buscar" clearable />
        </div>

        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            @if ($this->politicalParties->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-300 col-span-full">
                    No se encontraron partidos políticos.
                </p>
            @else
                @foreach ($this->politicalParties as $party)
                    <a wire:key="{{ $party->id }}" href="{{ route('parties.show', $party) }}"
                        class="group relative bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm hover:shadow-lg transition duration-300 backdrop-blur"
                        wire:navigate>

                        <div class="flex items-start gap-5">

                            {{-- Logo --}}
                            <div class="w-20 h-20 overflow-hidden bg-gray-100 dark:bg-white/10 flex items-center justify-center shrink-0">
                                @if($party->logo)
                                    <img src="{{ Storage::disk('logos')->url($party->logo) }}" alt="{{ $party->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-xl font-bold text-gray-400">
                                        {{ Str::substr($party->acronym ?? $party->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary transition">
                                    {{ $party->name }}
                                </h2>

                                @if($party->acronym)
                                    <p class="text-sm font-medium mt-1" style="color: {{ $party->color ?? '#6B7280' }}">
                                        {{ $party->acronym }}
                                    </p>
                                @endif

                                <p class="mt-3 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                                    {{ Str::limit($party->description, 150) }}
                                </p>

                                <div class="mt-5 flex items-center text-sm font-medium text-primary">
                                    Ver más detalles
                                    <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="absolute inset-0 rounded-2xl ring-1 ring-transparent group-hover:ring-primary/30 transition"></div>
                    </a>
                @endforeach
            @endif
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $this->politicalParties->links() }}
        </div>

    </div>
</div>
