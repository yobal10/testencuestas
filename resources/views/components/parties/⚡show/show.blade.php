<div class="min-h-screen bg-white dark:bg-[#1D293D] py-12">
    <div class="container mx-auto px-4 max-w-6xl">

        {{-- Header Partido --}}
        <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-sm mb-12">

            <div class="flex flex-col md:flex-row md:items-center gap-6">

                {{-- Logo --}}
                <div class="w-28 h-28 overflow-hidden bg-gray-100 dark:bg-white/10 flex items-center justify-center shrink-0">
                    @if($politicalParty->logo)
                        <img src="{{ Storage::disk('logos')->url($politicalParty->logo) }}" alt="{{ $politicalParty->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-3xl font-bold text-gray-400">
                            {{ Str::substr($politicalParty->acronym ?? $politicalParty->name, 0, 2) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        {{ $politicalParty->name }}
                    </h1>

                    @if($politicalParty->acronym)
                        <p class="mt-2 text-lg font-semibold" style="color: {{ $politicalParty->color ?? '#6B7280' }}">
                            {{ $politicalParty->acronym }}
                        </p>
                    @endif
                </div>
            </div>

            @if($politicalParty->description)
                <div class="mt-6 prose dark:prose-invert max-w-none">
                    {!! nl2br($politicalParty->description) !!}
                </div>
            @endif

        </div>

        {{-- Sección Candidatos --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Candidatos del partido
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($this->candidates as $candidate)
                    <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-5 shadow-sm hover:shadow-lg transition">

                        {{-- Foto --}}
                        <div class="w-full h-44 rounded-xl overflow-hidden bg-gray-100 dark:bg-white/10 mb-4 flex items-center justify-center">
                            @if($candidate->photo)
                                <img src="{{ Storage::disk('candidates_photos')->url($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 text-sm">Sin foto</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $candidate->name }}
                        </h3>

                        @if($candidate->number)
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Nº {{ $candidate->number }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <flux:button
                                class="w-full"
                                href="{{ route('parties.candidate', [$politicalParty, $candidate]) }}"
                                wire:navigate
                            >
                                Ver perfil
                            </flux:button>
                        </div>

                    </div>
                @empty
                    <p class="col-span-full text-gray-600 dark:text-gray-300">
                        Este partido aún no tiene candidatos registrados.
                    </p>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if ($this->candidates->hasPages())
                <div class="mt-10">
                    {{ $this->candidates->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
