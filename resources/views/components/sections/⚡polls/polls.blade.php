<section class="mx-auto max-w-7xl px-6 py-16">
    <div class="mb-12 flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
        <div>
            <span class="mb-4 inline-block rounded-full bg-indigo-100 px-4 py-1 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">Participacion universitaria</span>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white lg:text-4xl">Encuestas que convierten opiniones en mejoras</h2>
        </div>
        <flux:button href="{{ route('polls') }}" wire:navigate>Explorar encuestas <flux:icon.chevron-right class="h-5 w-5" /></flux:button>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        @forelse($polls as $survey)
            <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-900">
                <div class="relative h-40 overflow-hidden bg-linear-to-br from-indigo-100 via-white to-emerald-100 dark:from-slate-800 dark:via-slate-900 dark:to-emerald-950">
                    <div class="absolute -right-8 -top-12 h-40 w-40 rounded-full border-[18px] border-indigo-200/60 dark:border-indigo-400/10"></div>
                    <div class="absolute bottom-4 left-6 h-16 w-16 rounded-2xl bg-white/70 shadow-sm backdrop-blur dark:bg-white/10"></div>
                    <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold capitalize text-slate-800 dark:bg-slate-900/90 dark:text-white">{{ str_replace('_', ' ', $survey->survey_type) }}</span>
                    <span class="absolute right-4 top-4 rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white shadow">Disponible</span>
                </div>
                <div class="flex flex-1 flex-col p-6">
                    <h3 class="mb-2 line-clamp-2 text-lg font-bold text-slate-900 dark:text-white">{{ $survey->title }}</h3>
                    <p class="mb-5 line-clamp-2 text-sm text-slate-600 dark:text-slate-400">{{ $survey->description }}</p>
                    <div class="mb-5 flex flex-wrap gap-4 text-xs text-slate-500 dark:text-slate-400">
                        <span class="inline-flex items-center gap-1"><flux:icon.building-2 class="h-4 w-4" />{{ $survey->faculty?->name ?? 'Institucional' }}</span>
                        <span class="inline-flex items-center gap-1"><flux:icon.calendar-1 class="h-4 w-4" />{{ $survey->period?->name ?? 'Periodo vigente' }}</span>
                    </div>
                    <flux:button href="{{ route('polls.show', $survey->slug) }}" wire:navigate class="mt-auto w-full" icon="arrow-right">Responder encuesta</flux:button>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 p-12 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">No hay encuestas institucionales disponibles.</div>
        @endforelse
    </div>
</section>
