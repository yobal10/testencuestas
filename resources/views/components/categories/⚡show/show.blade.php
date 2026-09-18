<div class="min-h-screen bg-white dark:bg-[#1D293D] py-12">
    <div class="container mx-auto px-4">

        {{-- Header categoría --}}
        <div class="max-w-3xl mb-12">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-white">
                {{ $category->name }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ $category->description }}
            </p>
        </div>

        <div class="mb-8">
            <flux:input icon="magnifying-glass" wire:model.live.300ms="search" placeholder="Ingrese el título de la encuesta a buscar" clearable />
        </div>

        {{-- Grid encuestas --}}
        <div class="grid gap-6 grid-cols-1">
            @forelse ($this->polls as $poll)
                <a
                    href="{{ route('polls.show', $poll->slug) }}"
                    class="group relative rounded-2xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 backdrop-blur overflow-hidden"
                    wire:navigate
                >
                    <div class="absolute inset-0 bg-linear-to-br from-primary/5 via-transparent to-primary/10 opacity-0 group-hover:opacity-100 transition"></div>

                    <div class="relative md:flex">

                        {{-- Imagen --}}
                        @if ($poll->image)
                            <div class="md:w-64 h-48 md:h-auto shrink-0 overflow-hidden">
                                <img src="{{ Storage::disk('polls')->url($poll->image) }}" alt="{{ $poll->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                        @endif

                        {{-- Contenido --}}
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-primary transition">
                                    {{ $poll->title }}
                                </h2>

                                <span class="text-xs px-3 py-1 rounded-full font-medium
                                    {{ $poll->status === 'activo' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' : 'bg-gray-200 text-gray-700 dark:bg-white/10 dark:text-gray-300' }}">
                                    {{ ucfirst($poll->status) }}
                                </span>
                            </div>

                            {{-- Meta info --}}
                            <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-3 text-xs text-gray-500 dark:text-gray-400 mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ ucfirst($poll->scope) }}
                                </div>


                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                                    </svg>
                                    Finaliza: {{ $poll->ends_at->format('d M Y H:i') }}
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-3.866 0-7 1.79-7 4v4h14v-4c0-2.21-3.134-4-7-4z"/>
                                        <circle cx="12" cy="8" r="3"/>
                                    </svg>
                                    {{ $poll->candidates_count }} candidatos
                                </div>

                                <div class="flex items-center gap-2 font-semibold text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ number_format($poll->votes_count) }} votos
                                </div>
                            </div>

                            <div class="mt-auto flex items-center text-sm font-medium text-primary">
                                Ver encuesta
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-center text-gray-600 dark:text-gray-300">
                    No hay encuestas activas en esta categoría por el momento.
                </p>
            @endforelse
        </div>

        {{-- Paginación --}}
        @if ($this->polls->hasPages())
            <div class="mt-12">
                {{ $this->polls->links() }}
            </div>
        @endif

    </div>
</div>
