<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16">

    {{-- Background Gradient --}}
    <div class="absolute inset-0 bg-linear-to-br from-white via-slate-50 to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-700"></div>

    {{-- Soft radial highlight --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.6),transparent_60%)] dark:bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.05),transparent_60%)]"></div>

    {{-- Subtle pattern --}}
    <div class="absolute inset-0 opacity-[0.04] mask-[radial-gradient(ellipse_at_center,black,transparent_70%)]"
         style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'0.08\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/svg%3E');">
    </div>

    {{-- Content --}}
    <div class="relative z-10 mx-auto max-w-6xl px-6 py-20 text-center text-slate-900 dark:text-white">

        {{-- Title --}}
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold mb-6 leading-tight">
            Encuestas Electorales de candidatos y partidos políticos en el
            <span class="block relative mt-2">
                <span class="relative z-10">Perú 2025</span>
                <span class="absolute inset-x-0 bottom-2 h-4 bg-[#D91023] dark:bg-[#D91023]/30 -z-10 rounded"></span>
            </span>
        </h1>

        {{-- Subtitle --}}
        <p class="text-lg sm:text-xl text-slate-600 dark:text-white/80 mb-10 max-w-2xl mx-auto leading-relaxed">
            Participa en las encuestas y conoce la opinión de los peruanos.
            Tu voz es importante para el futuro de nuestro país.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('polls') }}"
               class="group inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-slate-900 font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
               wire:navigate>
                Ver Encuestas Activas
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('how-it-works') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-300 dark:border-white/30 text-slate-700 dark:text-white font-semibold text-lg hover:bg-slate-900/5 dark:hover:bg-white/10 transition-all duration-300 hover:scale-105"
               wire:navigate>
                ¿Cómo Funciona?
            </a>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mt-16 max-w-3xl mx-auto">
            <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white/60 dark:bg-white/10 backdrop-blur border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                <flux:icon.chart-no-axes-column-increasing />
                <span class="text-2xl sm:text-3xl font-bold">{{ $totalPolls }}+</span>
                <span class="text-sm text-slate-600 dark:text-white/70">Encuestas</span>
            </div>

            <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white/60 dark:bg-white/10 backdrop-blur border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                <flux:icon.users />
                <span class="text-2xl sm:text-3xl font-bold">{{ $totalVotes }}+</span>
                <span class="text-sm text-slate-600 dark:text-white/70">Votos Emitidos</span>
            </div>

            <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white/60 dark:bg-white/10 backdrop-blur border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                <flux:icon.building-2 />
                <span class="text-2xl sm:text-3xl font-bold">{{ $totalPoliticalParties }}+</span>
                <span class="text-sm text-slate-600 dark:text-white/70">Partidos Políticos</span>
            </div>

            <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white/60 dark:bg-white/10 backdrop-blur border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                <flux:icon.users-round />
                <span class="text-2xl sm:text-3xl font-bold">{{ $totalCandidates }}+</span>
                <span class="text-sm text-slate-600 dark:text-white/70">Candidatos</span>
            </div>
        </div>
    </div>

    {{-- Bottom Wave --}}
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 120" class="w-full h-auto fill-white dark:fill-slate-950">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L0,120Z"/>
        </svg>
    </div>

</section>
