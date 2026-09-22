<main class="mx-auto max-w-4xl px-6 py-12">
    <div class="mb-8 rounded-3xl bg-linear-to-br from-slate-950 via-indigo-950 to-emerald-900 p-8 text-white shadow-xl sm:p-12">
        <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em]">Encuesta universitaria</span>
        <h1 class="mt-6 text-3xl font-black leading-tight sm:text-5xl">{{ $survey->title }}</h1>
        <p class="mt-5 max-w-2xl text-slate-200">{{ $survey->description }}</p>
        <div class="mt-8 flex flex-wrap gap-3 text-sm text-slate-200">
            <span class="rounded-full bg-white/10 px-3 py-2">{{ $survey->faculty?->name ?? 'Institucional' }}</span>
            <span class="rounded-full bg-white/10 px-3 py-2">{{ $survey->program?->name ?? 'Comunidad universitaria' }}</span>
            <span class="rounded-full bg-white/10 px-3 py-2">{{ $survey->period?->name ?? 'Periodo vigente' }}</span>
            @if($survey->is_anonymous)<span class="rounded-full bg-emerald-400/20 px-3 py-2 text-emerald-100">Respuesta anónima</span>@endif
        </div>
    </div>

    @if($submitted)
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-8 text-center text-emerald-900 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-100">
            <flux:icon.circle-check class="mx-auto h-12 w-12" />
            <h2 class="mt-4 text-2xl font-bold">Gracias por participar</h2>
            <p class="mt-2">Tu respuesta fue registrada y ayudará a mejorar la experiencia universitaria.</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            @foreach($survey->questions as $question)
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <label class="block text-base font-semibold text-slate-900 dark:text-white">
                        {{ $loop->iteration }}. {{ $question->prompt }}
                        @if($question->is_required)<span class="text-rose-500">*</span>@endif
                    </label>
                    @if($question->help_text)<p class="mt-1 text-sm text-slate-500">{{ $question->help_text }}</p>@endif

                    @if($question->question_type === 'text')
                        <textarea wire:model="answers.{{ $question->id }}" rows="4" class="mt-4 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-950"></textarea>
                    @else
                        <div class="mt-4 grid grid-cols-5 gap-2 sm:max-w-md">
                            @foreach(range(1, 5) as $rating)
                                <label class="cursor-pointer text-center">
                                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $rating }}" class="peer sr-only">
                                    <span class="block rounded-xl border border-slate-200 px-3 py-3 text-sm font-semibold text-slate-600 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white dark:border-slate-700 dark:text-slate-300">{{ $rating }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-2 flex max-w-md justify-between text-xs text-slate-500"><span>Muy bajo</span><span>Excelente</span></div>
                    @endif
                    @error("answers.{$question->id}")<p class="mt-2 text-sm text-rose-600">Este campo es obligatorio.</p>@enderror
                </section>
            @endforeach

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="check">Enviar respuestas</flux:button>
            </div>
        </form>
    @endif
</main>
