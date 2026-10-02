<div class="min-h-screen bg-white dark:bg-[#1D293D] py-16">
    <div class="mx-auto max-w-7xl px-6">

        <div class="mx-auto max-w-3xl text-center">
            <span class="inline-flex rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                Comunidad académica
            </span>

            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                Una comunidad que participa, opina y mejora
            </h1>

            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                La comunidad universitaria puede expresar sus opiniones mediante
                encuestas diseñadas para conocer la experiencia académica y promover
                la mejora continua.
            </p>
        </div>

        <div class="mt-16 grid gap-8 md:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-900">
                <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                    <flux:icon.users class="h-7 w-7" />
                </div>

                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    Participación
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">
                    La comunidad puede aportar opiniones y experiencias de manera
                    sencilla y organizada.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-900">
                <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <flux:icon.chart-no-axes-column-increasing class="h-7 w-7" />
                </div>

                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    Información
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">
                    Las respuestas ayudan a identificar tendencias y necesidades
                    dentro de la institución.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-900">
                <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300">
                    <flux:icon.building-2 class="h-7 w-7" />
                </div>

                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    Mejora continua
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">
                    La información recopilada puede convertirse en acciones de
                    mejora académica e institucional.
                </p>
            </div>

        </div>

        <div class="mt-16 text-center">
            <a
                href="{{ route('polls') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-700 px-6 py-3 font-bold text-white shadow-lg transition hover:scale-105 hover:shadow-xl"
            >
                Ver encuestas
                <flux:icon.chevron-right class="h-5 w-5" />
            </a>
        </div>

    </div>
</div>