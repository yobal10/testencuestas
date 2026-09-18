<section class="mx-auto max-w-7xl px-6 py-16">
    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
            Encuestas Electorales
        </h1>
        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Explora las encuestas electorales más recientes y participa votando por tus candidatos favoritos.
        </p>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">

        <div class="space-y-6">
            <h2 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">Filtrar encuestas</h2>

            <flux:input icon="magnifying-glass" wire:model.live.300ms="search" placeholder="Buscar encuesta por nombre..." clearable />

            {{-- Scope --}}
            <flux:select wire:model.live="scope" variant="listbox" clearable placeholder="Ámbito de la encuesta">
                <flux:select.option value="nacional">Nacional</flux:select.option>
                <flux:select.option value="regional">Regional</flux:select.option>
                <flux:select.option value="provincial">Provincial</flux:select.option>
                <flux:select.option value="distrital">Distrital</flux:select.option>
            </flux:select>

            {{-- Región --}}
            @if(in_array($scope, ['regional','provincial','distrital']))
                <flux:select wire:model.live="regionId" variant="listbox" searchable clearable placeholder="Selecciona región">
                    @foreach($this->regions as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            {{-- Provincia --}}
            @if(in_array($scope, ['provincial','distrital']) && $regionId)
                <flux:select wire:model.live="provinceId" variant="listbox" searchable clearable placeholder="Selecciona provincia">
                    @foreach($this->provinces as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            {{-- Distrito --}}
            @if($scope === 'distrital' && $provinceId)
                <flux:select wire:model.live="districtId" variant="listbox" searchable clearable placeholder="Selecciona distrito">
                    @foreach($this->districts as $id => $name)
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
                @forelse($this->polls as $poll)
                    <div class="group rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 shadow-sm hover:shadow-lg flex flex-col">
                        <div class="h-40 relative overflow-hidden">

                            @if($poll->image)
                                <img src="{{ Storage::disk('polls')->url($poll->image) }}"
                                    alt="{{ $poll->title }}"
                                    class="absolute inset-0 w-full h-full object-cover">

                                <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/40 to-black/10"></div>
                            @else
                                <div class="absolute inset-0 bg-linear-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700"></div>
                            @endif

                            <div class="absolute top-4 left-4 flex flex-wrap gap-2 z-10">
                                <span class="px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-xs font-semibold text-slate-800 dark:text-white">
                                    {{ $poll->category->name }}
                                </span>
                            </div>

                            <div class="absolute top-4 right-4 z-10">
                                @if($poll->status === 'activo')
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
                                    <flux:icon.map-pin class="w-4 h-4" />
                                    @if($poll->scope !== 'nacional')
                                        <div class="text-xs">
                                            {{ $poll->region->name ?? '' }}
                                            @if($poll->province) - {{ $poll->province->name }} @endif
                                            @if($poll->district) - {{ $poll->district->name }} @endif
                                        </div>
                                    @else
                                        <p class="text-xs">{{ ucfirst($poll->scope) }}</p>
                                    @endif
                                </div>

                                @if($poll->ends_at)
                                    <div class="flex items-center gap-1">
                                        <flux:icon.calendar-1 class="w-4 h-4" />
                                        Finaliza el {{ $poll->ends_at->format('d/m/Y') }}
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
