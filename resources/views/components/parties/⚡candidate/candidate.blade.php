<div class="min-h-screen bg-white dark:bg-[#1D293D] py-12">
    <div class="container mx-auto px-4 max-w-5xl">

        {{-- Header candidato --}}
        <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-sm mb-10">
            <div class="flex flex-col md:flex-row gap-8">

                {{-- Foto --}}
                <div class="w-40 h-40 rounded-2xl overflow-hidden bg-gray-100 dark:bg-white/10 shrink-0 flex items-center justify-center">
                    @if($candidate->photo)
                        <img src="{{ Storage::disk('candidates_photos')->url($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-sm">Sin foto</span>
                    @endif
                </div>

                {{-- Info principal --}}
                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        {{ $candidate->name }}
                    </h1>

                    @if($candidate->number)
                        <p class="mt-2 text-lg font-semibold text-primary">
                            Nº {{ $candidate->number }}
                        </p>
                    @endif

                    {{-- Partido político --}}
                    @if($candidate->politicalParty)
                        <div class="mt-4 flex items-center gap-3">
                            @if($candidate->politicalParty->logo)
                                <img src="{{ Storage::disk('logos')->url($candidate->politicalParty->logo) }}"
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-white/10">
                            @endif

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Partido político</p>
                                <a href="{{ route('parties.show', $candidate->politicalParty) }}"
                                   class="font-semibold hover:text-primary transition"
                                   style="color: {{ $candidate->politicalParty->color ?? '' }}"
                                   wire:navigate>
                                    {{ $candidate->politicalParty->name }}
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Encuesta --}}
                    @if($candidate->poll)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Participa en la encuesta</p>
                            <a href="{{ route('polls.show', $candidate->poll->slug) }}"
                               class="inline-flex items-center gap-2 font-medium text-primary hover:underline"
                                wire:navigate>
                                {{ $candidate->poll->title }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Biografía --}}
        @if($candidate->biography)
            <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-sm mb-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
                    Biografía
                </h2>
                <p class="prose dark:prose-invert max-w-none">
                    {!! nl2br($candidate->biography) !!}
                </p>
            </div>
        @endif
    </div>
</div>
