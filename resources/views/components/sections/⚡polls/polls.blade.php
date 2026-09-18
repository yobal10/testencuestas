<section class="mx-auto max-w-7xl px-6 py-16">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-6">
        <div>
            <span class="inline-block px-4 py-1 rounded-full bg-slate-900/5 dark:bg-white/10 text-slate-700 dark:text-white text-sm font-semibold mb-4">
                Encuestas Destacadas
            </span>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">
                Participa y haz escuchar tu voz
            </h2>
        </div>

        <flux:button href="{{ route('polls') }}" wire:navigate>
            Ver todas las encuestas
            <flux:icon.chevron-right class="h-5 w-5" />
        </flux:button>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        @foreach($polls as $poll)
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
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 transition">
                        {{ $poll->title }}
                    </h3>

                    <div class="flex flex-wrap justify-between gap-4 text-sm text-slate-500 dark:text-slate-400 mb-4">
                        <div class="flex items-center justify-center gap-1">
                            <flux:icon.map-pin class="w-4 h-4" />
                            @if($poll->scope !== 'nacional')
                                <div>
                                    {{ $poll->region->name ?? '' }}
                                    @if($poll->province) - {{ $poll->province->name }} @endif
                                    @if($poll->district) - {{ $poll->district->name }} @endif
                                </div>
                            @else
                                <p>{{ ucfirst($poll->scope) }}</p>
                            @endif
                        </div>

                        @if($poll->ends_at)
                            <div class="flex items-center justify-center gap-1">
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
        @endforeach
    </div>
</section>
