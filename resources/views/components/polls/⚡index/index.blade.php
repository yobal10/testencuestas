<section class="mx-auto max-w-7xl px-6 py-16">
    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
            Encuestas universitarias
        </h1>
        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Explora evaluaciones de docentes, cursos, servicios y experiencia estudiantil para impulsar la mejora continua universitaria.
        </p>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">

        <div class="space-y-6">
            <h2 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">Filtrar encuestas</h2>

            <flux:input icon="magnifying-glass" wire:model.live.300ms="search" placeholder="Buscar encuesta por nombre..." clearable />

            {{-- Scope --}}
            <flux:select wire:model.live="facultyId" variant="listbox" searchable clearable placeholder="Facultad">
                @foreach($this->faculties as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>

            @if($facultyId)
                <flux:select wire:model.live="programId" variant="listbox" searchable clearable placeholder="Programa académico">
                    @foreach($this->programs as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            <flux:button icon="trash" variant="danger" wire:click="resetFilters" class="w-full">
                Limpiar filtros
            </flux:button>
        </div>

        <div class="lg:col-span-2">
            <div class="grid md:grid-cols-2 gap-8">
                @forelse($this->surveys as $poll)
                    <div class="group rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 shadow-sm hover:shadow-lg flex flex-col">
                        <div class="h-40 relative overflow-hidden">

                            <div class="absolute inset-0 bg-linear-to-br from-indigo-100 via-white to-emerald-100 dark:from-slate-800 dark:to-emerald-950"></div>

                            <div class="absolute top-4 left-4 flex flex-wrap gap-2 z-10">
                                <span class="px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-xs font-semibold text-slate-800 dark:text-white">
                                    {{ str_replace('_', ' ', $poll->survey_type) }}
                                </span>
                            </div>

                            <div class="absolute top-4 right-4 z-10">
                                @if(in_array($poll->status, ['published', 'active']))
                                    <span class="px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-semibold shadow">
                                        Encuesta activa
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-slate-700 text-white text-xs font-semibold shadow">
                                        Encuesta finalizada
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 transition">
                                {{ $poll->title }}
                            </h3>

                            <div class="flex flex-wrap justify-between gap-4 text-sm text-slate-500 dark:text-slate-400 mb-4">
                                <div class="flex items-center gap-1">
                                    <flux:icon.building-2 class="w-4 h-4" />
                                    <div class="text-xs">{{ $poll->faculty?->name ?? 'Institucional' }}</div>
                                </div>

                                @if($poll->closes_at)
                                    <div class="flex items-center gap-1">
                                        <flux:icon.calendar-1 class="w-4 h-4" />
                                        Finaliza el {{ $poll->closes_at->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto flex gap-2">
                                <flux:button type="button" icon="eye" variant="primary" href="{{ route('polls.show', $poll->slug) }}" class="w-full" wire:navigate>
                                    Ver Encuesta
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">
                        No hay encuestas con esos filtros.
                    </p>
                @endforelse
            </div>

            {{-- Paginación --}}
            <div class="mt-12">
                {{ $this->polls->links() }}
            </div>
        </div>
    </div>
</section>
