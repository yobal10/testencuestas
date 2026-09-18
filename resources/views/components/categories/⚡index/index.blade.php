<div class="min-h-screen bg-white dark:bg-[#1D293D] py-12">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-white">
                Categorías de Encuestas
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Navega por las diferentes categorías y descubre las encuestas activas en cada una.
            </p>
        </div>

        <div class="mb-8">
            <flux:input icon="magnifying-glass" wire:model.live.300ms="search" placeholder="Ingrese el nombre de la categoría a buscar" clearable />
        </div>

        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            @if ($this->categories->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-300 col-span-full">
                    No se encontraron categorías.
                </p>
            @else
                @foreach ($this->categories as $category)
                    <a
                        href="{{ route('categories.show', $category) }}"
                        class="group relative rounded-2xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 backdrop-blur"
                        wire:navigate
                    >
                        <div class="absolute inset-0 rounded-2xl bg-linear-to-br from-primary/5 via-transparent to-primary/10 opacity-0 group-hover:opacity-100 transition"></div>

                        <div class="relative">
                            <div class="flex items-start justify-between mb-2 gap-3">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-primary transition">
                                    {{ $category->name }}
                                </h2>

                                <span class="shrink-0 text-xs font-semibold px-3 py-1 rounded-full bg-primary/10 text-primary dark:bg-primary/20">
                                    {{ $category->active_polls_count ?? 0 }} {{ \Illuminate\Support\Str::plural('encuesta', $category->active_polls_count) }}
                                </span>
                            </div>

                            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300 line-clamp-3">
                                {{ Str::limit($category->description, 150) }}
                            </p>

                            <div class="mt-6 flex items-center text-sm font-medium text-primary">
                                Ver encuestas
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="mt-10">
            {{ $this->categories->links() }}
        </div>
    </div>
</div>
