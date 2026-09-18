<div class="min-h-screen py-8 px-4" x-data="voteSecurityHandler()">
    <div class="container mx-auto max-w-7xl">

        <div class="dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700">
            <div class="w-full shadow-lg overflow-hidden bg-white dark:bg-slate-900">
                @if ($poll->image)
                    <div class="relative w-full h-64 sm:h-80 md:h-96 lg:h-[420px]">
                        <img src="{{ Storage::disk('polls')->url($poll->image) }}"
                            alt="{{ $poll->title }}"
                            class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/30 to-black/20"></div>

                        <div class="absolute top-0 left-0 right-0 z-10 p-4">
                            <div class="flex items-start justify-between gap-2 flex-wrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-white/90 text-slate-900 backdrop-blur">
                                    {{ $poll->category->name }}
                                </span>

                                @if($poll->status === 'activo')
                                    <span class="px-3 py-1 rounded-full bg-green-500 text-white text-xs font-semibold shadow">
                                        Encuesta activa
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-slate-700 text-white text-xs font-semibold shadow">
                                        Encuesta finalizada
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative w-full h-48 sm:h-64 md:h-96 lg:h-[300px] overflow-hidden rounded-xl bg-linear-to-br from-red-600 via-rose-600 to-red-800">

                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_30%_20%,white,transparent_40%),radial-gradient(circle_at_70%_80%,white,transparent_40%)]"></div>

                        <div class="absolute inset-0 bg-black/30"></div>

                        <div class="absolute top-0 left-0 right-0 z-10 p-4">
                            <div class="flex items-start justify-between gap-2 flex-wrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-white/90 text-slate-900 backdrop-blur">
                                    {{ $poll->category->name }}
                                </span>

                                @if($poll->status === 'activo')
                                    <span class="px-3 py-1 rounded-full bg-green-500 text-white text-xs font-semibold shadow">
                                        Encuesta activa
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-slate-700 text-white text-xs font-semibold shadow">
                                        Encuesta finalizada
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="absolute inset-0 flex flex-col items-center justify-center px-6 pt-10 sm:pt-0">
                            <h2 class="text-white text-xl md:text-3xl font-bold drop-shadow-lg">
                                {{ $poll->title }}
                            </h2>
                        </div>
                    </div>
                @endif

                <div class="px-6 md:px-10 py-8">
                    <div class="max-w-6xl mx-auto">

                        <div class="prose dark:prose-invert max-w-none text-sm md:text-base mb-8">
                            {!! nl2br($poll->description) !!}
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                            <div class="flex items-center gap-3 bg-slate-100 dark:bg-white/5 rounded-xl px-4 py-3">
                                <flux:icon.map-pin />
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Ubicación</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        @if($poll->scope !== 'nacional')
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $poll->region->name ?? '' }}
                                                @if($poll->province) - {{ $poll->province->name }} @endif
                                                @if($poll->district) - {{ $poll->district->name }} @endif
                                            </p>
                                        @else
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($poll->scope) }}</p>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 bg-slate-100 dark:bg-white/5 rounded-xl px-4 py-3">
                                <flux:icon.clock-8 />
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Finaliza</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $poll->ends_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 bg-slate-100 dark:bg-white/5 rounded-xl px-4 py-3 sm:col-span-2 lg:col-span-1">
                                <flux:icon.clipboard-plus />
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Votos emitidos</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $this->totalVotes }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <flux:icon.file-text />
                        Lista de candidatos
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">

                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Candidato
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Número
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Partido
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Logo
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Votos
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    %
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($poll->candidates as $candidate)
                                <tr class="{{ $this->isVotedCandidate($candidate->id) ? 'bg-[#d6f4df] dark:bg-[#253949]' : '' }}">
                                    <td class="px-4 py-3">
                                        @php
                                            $isThisCandidate = $userVote?->candidate_id === $candidate->id;
                                        @endphp
                                        @if($this->isPollClosed)
                                            @if($isThisCandidate)
                                                <flux:button type="button" icon="vote" disabled>
                                                    Marcado
                                                </flux:button>
                                            @endif
                                        @elseif(!$userVote)
                                            <flux:button type="button" icon="x"
                                                wire:click="selectedVote({{ $candidate->id }})"
                                                class="cursor-pointer">
                                                Marcar
                                            </flux:button>
                                        @elseif($isThisCandidate)
                                            <flux:button type="button" icon="vote" disabled>
                                                Marcado
                                            </flux:button>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <label for="candidate-{{ $candidate->id }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $candidate->name }}
                                        </label>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center">
                                            @if($candidate?->photo)
                                                <img
                                                    src="{{ Storage::disk('candidates_photos')->url($candidate->photo) }}"
                                                    alt="{{ $candidate->name }}"
                                                    class="w-12 h-12 object-cover ring-gray-200 dark:ring-gray-600"
                                                >
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($candidate->number)
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-linear-to-br from-blue-500 to-indigo-600 shadow-md">
                                                <span class="font-bold text-white">{{ $candidate->number }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $candidate->politicalParty->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center">
                                            @if($candidate->politicalParty?->logo)
                                                <img
                                                    src="{{ Storage::disk('logos')->url($candidate->politicalParty->logo) }}"
                                                    alt="{{ $candidate->politicalParty->name }}"
                                                    class="w-10 h-10 object-cover ring-gray-200 dark:ring-gray-600"
                                                >
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="font-bold text-blue-600 dark:text-blue-400">
                                            {{ $candidate->votes->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($this->totalVotes > 0)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ round(($candidate->votes->count() / $this->totalVotes) * 100, 1) }}%
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">0%</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="{{ $this->isSpecialVote('no sabe') ? 'bg-[#d6f4df] dark:bg-[#253949]' : '' }}">
                                <td class="px-4 py-3">
                                    @php
                                        $isNoSabe = $userVote?->vote_type === 'no sabe';
                                    @endphp
                                    @if($this->isPollClosed)
                                        @if($isNoSabe)
                                            <flux:button type="button" icon="vote" disabled>
                                                Marcado
                                            </flux:button>
                                        @endif
                                    @elseif(!$userVote)
                                        <flux:button type="button" icon="x"
                                            wire:click="selectedVote('no sabe')"
                                            class="cursor-pointer">
                                            Marcar
                                        </flux:button>
                                    @elseif($isNoSabe)
                                        <flux:button type="button" icon="vote" disabled>
                                            Marcado
                                        </flux:button>
                                    @endif
                                </td>
                                <td colspan="5" class="px-4 py-3">
                                    <label for="vote-null">
                                        <div class="flex items-center gap-3">
                                            <div>
                                                <p class="text-sm font-semibold  text-gray-900 dark:text-gray-100">No sabe / No opina</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">No tengo una opinión clara o no tengo preferencia</p>
                                            </div>
                                        </div>
                                    </label>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-bold text-red-600 dark:text-red-400">
                                        {{ $this->knowVotes }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($this->totalVotes > 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            {{ round(($this->knowVotes / $this->totalVotes) * 100, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">0%</span>
                                    @endif
                                </td>
                            </tr>

                            <tr class="{{ $this->isSpecialVote('ninguno') ? 'bg-[#d6f4df] dark:bg-[#253949]' : '' }}">
                                <td class="px-4 py-3">
                                    @php
                                        $isNinguno = $userVote?->vote_type === 'ninguno';
                                    @endphp
                                    @if($this->isPollClosed)
                                        @if($isNinguno)
                                            <flux:button type="button" icon="vote" disabled>
                                                Marcado
                                            </flux:button>
                                        @endif
                                    @elseif(!$userVote)
                                        <flux:button type="button" icon="x"
                                            wire:click="selectedVote('ninguno')"
                                            class="cursor-pointer">
                                            Marcar
                                        </flux:button>
                                    @elseif($isNinguno)
                                        <flux:button type="button" icon="vote" disabled>
                                            Marcado
                                        </flux:button>
                                    @endif
                                </td>
                                <td colspan="5" class="px-4 py-3">
                                    <label for="vote-null">
                                        <div class="flex items-center gap-3">
                                            <div>
                                                <p class="text-sm font-semibold  text-gray-900 dark:text-gray-100">Ninguno de los anteriores</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">Ninguno de las opciones me representa o que no votaría</p>
                                            </div>
                                        </div>
                                    </label>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-bold text-red-600 dark:text-red-400">
                                        {{ $this->noneVotes }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($this->totalVotes > 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            {{ round(($this->noneVotes / $this->totalVotes) * 100, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">0%</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-8">
                <div class="bg-linear-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <flux:icon.chart-no-axes-column-increasing />
                        Resumen de votos
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 items-stretch">
                    <div class="bg-linear-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl p-5 border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">Total de votos</p>
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $this->totalVotes }}</p>
                    </div>

                    <div class="bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-700/30 dark:to-gray-600/30 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">No sabe / No opina</p>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-liResumen nejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">{{ $this->knowVotes }}</p>
                        @if($this->totalVotes > 0)
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ round(($this->knowVotes / $this->totalVotes) * 100, 1) }}%
                            </p>
                        @endif
                    </div>

                    <div class="bg-linear-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 rounded-xl p-5 border border-red-200 dark:border-red-700">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-red-900 dark:text-red-100">Ninguno de los anteriores</p>
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $this->noneVotes }}</p>
                        @if($this->totalVotes > 0)
                            <p class="text-xs text-red-500 dark:text-red-400 mt-1">
                                {{ round(($this->noneVotes / $this->totalVotes) * 100, 1) }}%
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Chart --}}
                <div class="flex justify-center bg-white dark:bg-[#1D293D] rounded-lg shadow-lg p-6 overflow-hidden">
                    <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-200 dark:scrollbar-track-gray-800">
                        <div x-data="pollChart()"
                            x-init="init()"
                            class="inline-flex items-end gap-3 min-w-full pb-4"
                            style="min-width: {{ (count($chartData['candidatos']) + 2) * 120 }}px;"
                            wire:key="chart-{{ $this->totalVotes }}">

                            @php
                                $allItems = array_merge(
                                    $chartData['candidatos'],
                                    [$chartData['no_sabe'], $chartData['otros']]
                                );
                                $maxPorcentaje = collect($allItems)->max('porcentaje') ?: 100;
                            @endphp

                            @foreach($allItems as $index => $item)
                                <div class="flex flex-col items-center justify-end transition-all duration-700 ease-out"
                                    style="width: 120px; height: 500px;"
                                    x-data="{
                                        show: false,
                                        porcentaje: {{ $item['porcentaje'] }},
                                        maxPorcentaje: {{ $maxPorcentaje }},
                                        color: '{{ $item['color'] }}'
                                    }"
                                    x-init="setTimeout(() => show = true, {{ $index * 100 }})"
                                    wire:key="item-{{ $item['nombre'] }}-{{ $item['votos'] }}">

                                    @if($item['foto'])
                                        <div class="mb-2">
                                            <img src="{{ $item['foto'] }}"
                                                class="w-16 h-16 rounded-full object-cover border-4 shadow-lg transition-transform hover:scale-110"
                                                style="border-color: {{ $item['color'] }}"
                                                alt="{{ $item['nombre'] }}">
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <div class="w-16 h-16 rounded-full bg-gray-400 dark:bg-gray-600 border-4 shadow-lg flex items-center justify-center"
                                                style="border-color: {{ $item['color'] }}">
                                                <svg class="w-8 h-8 text-gray-200 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="text-center font-bold text-xl mb-2 text-gray-900 dark:text-gray-100">
                                        {{ $item['porcentaje'] }}%
                                    </div>

                                    <div class="w-full rounded-t-sm transition-all duration-700 ease-out relative group"
                                        :style="`height: ${show ? (porcentaje / maxPorcentaje) * 70 : 0}%; background-color: ${color}; min-height: ${porcentaje > 0 ? '40px' : '0px'}`">

                                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity rounded-t-sm"></div>

                                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                            {{ number_format($item['votos']) }} votos
                                        </div>
                                    </div>

                                    <div class="text-center mt-3 px-1 w-full">
                                        <div class="font-semibold text-sm leading-tight text-gray-900 dark:text-gray-100 wrap-break-word">
                                            @if(str_word_count($item['nombre']) > 1)
                                                @php
                                                    $palabras = explode(' ', $item['nombre']);
                                                @endphp
                                                <div>{{ $palabras[0] }}</div>
                                                <div>{{ implode(' ', array_slice($palabras, 1)) }}</div>
                                            @else
                                                {{ $item['nombre'] }}
                                            @endif
                                        </div>

                                        @if($item['partido_logo'])
                                            <img src="{{ $item['partido_logo'] }}"
                                                class="w-12 h-12 object-contain mx-auto mt-2"
                                                alt="{{ $item['partido_nombre'] }}">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Shares --}}
                <div class="bg-white dark:bg-[#1D293D] rounded-lg shadow-lg p-6 overflow-hidden">
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-4 justify-center items-center flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('polls.show', $poll->slug)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-12 h-12 shrink-0 rounded-full bg-[#1877F2] hover:bg-[#0d65d9] text-white flex items-center justify-center transition-all hover:scale-110 shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>

                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('polls.show', $poll->slug)) }}&text={{ urlencode('Mira los resultados de: ' . $poll->title) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-12 h-12 shrink-0 rounded-full bg-[#000000] hover:bg-[#1a1a1a] text-white flex items-center justify-center transition-all hover:scale-110 shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>

                            <a href="https://api.whatsapp.com/send?text={{ urlencode('Mira los resultados de: ' . $poll->title . ' ' . route('polls.show', $poll->slug)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-12 h-12 shrink-0 rounded-full bg-[#25D366] hover:bg-[#1fb355] text-white flex items-center justify-center transition-all hover:scale-110 shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>

                            <a href="https://www.instagram.com/"
                            target="_blank"
                            rel="noopener noreferrer"
                            onclick="alert('Copia el enlace y compártelo en tu historia de Instagram'); return false;"
                            class="w-12 h-12 shrink-0 rounded-full bg-linear-to-tr from-[#FEDA75] via-[#FA7E1E] to-[#D62976] hover:opacity-90 text-white flex items-center justify-center transition-all hover:scale-110 shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>

                        <div class="relative mx-auto" x-data="{ copied: false }">
                            <button @click="navigator.clipboard.writeText('{{ route('polls.show', $poll->slug) }}'); copied = true; setTimeout(() => copied = false, 3000)"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span x-text="copied ? 'Copiado!' : 'Copiar enlace'"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal --}}
    <flux:modal name="modal-vote" class="md:w-96" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirmar Votación</flux:heading>
                <flux:text class="mt-2">
                    @if ($vote_type === 'válido')
                        Estás seguro de votar por la opción: <br>
                        <span class="text-sm font-semibold">{{ $selectedCandidateName }}</span>
                    @else
                        Estás seguro de marcar por la opción: <br>
                        <span class="text-sm font-semibold">{{ Str::ucfirst($vote_type) }}</span>
                    @endif
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="danger">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button type="button" @click="submitVote()" variant="primary">Confirmar Votación</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

@push('scripts')
    <script>
        function voteSecurityHandler() {
            return {
                async init() {
                    const fingerprint = await this.generateFingerprint();
                    @this.set('clientFingerprint', fingerprint);
                },

                async generateFingerprint() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    ctx.textBaseline = 'top';
                    ctx.font = '14px Arial';
                    ctx.fillText('vote-fingerprint', 2, 2);

                    const data = {
                        canvas: canvas.toDataURL(),
                        userAgent: navigator.userAgent,
                        language: navigator.language,
                        languages: navigator.languages?.join(',') || '',
                        platform: navigator.platform,
                        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                        screenResolution: `${screen.width}x${screen.height}x${screen.colorDepth}`,
                        availableScreenResolution: `${screen.availWidth}x${screen.availHeight}`,
                        hardwareConcurrency: navigator.hardwareConcurrency || 0,
                        deviceMemory: navigator.deviceMemory || 0,
                        maxTouchPoints: navigator.maxTouchPoints || 0,
                        plugins: Array.from(navigator.plugins || []).map(p => p.name).join(','),
                        webgl: this.getWebGLFingerprint()
                    };

                    const textData = JSON.stringify(data);
                    const encoder = new TextEncoder();
                    const dataBuffer = encoder.encode(textData);
                    const hashBuffer = await crypto.subtle.digest('SHA-256', dataBuffer);
                    const hashArray = Array.from(new Uint8Array(hashBuffer));
                    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                },

                getWebGLFingerprint() {
                    try {
                        const canvas = document.createElement('canvas');
                        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
                        if (!gl) return 'no-webgl';

                        const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
                        if (debugInfo) {
                            return gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
                        }
                        return 'no-debug-info';
                    } catch (e) {
                        return 'error';
                    }
                },

                async submitVote() {
                    const fingerprint = await this.generateFingerprint();
                    @this.set('clientFingerprint', fingerprint);
                    await @this.vote();
                }
            }
        }

        function pollChart() {
            return {
                init() {
                    console.log('Chart initialized');
                }
            }
        }
    </script>
@endpush
