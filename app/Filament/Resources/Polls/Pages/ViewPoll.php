<?php

namespace App\Filament\Resources\Polls\Pages;

use App\Filament\Resources\Polls\PollResource;
use App\Models\Poll;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewPoll extends ViewRecord
{
    protected static string $resource = PollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('exportPdf')
                ->label('Exportar PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->action(function () {
                    return response()->streamDownload(function () {
                        $data = $this->getPollData($this->record);
                        $pdf = Pdf::loadView('pdf.poll-results', $data);
                        echo $pdf->output();
                    }, 'resultados-' . $this->record->slug . '.pdf');
                })
                ->requiresConfirmation()
                ->modalHeading('Exportar resultados')
                ->modalDescription('¿Deseas exportar los resultados de esta encuesta?')
                ->modalSubmitActionLabel('Exportar'),
        ];
    }

    protected function getPollData(Poll $poll): array
    {
        $poll->load(['region', 'province', 'district']);

        $ubicacion = null;

        if ($poll->scope === 'regional' && $poll->region) {
            $ubicacion = 'Región: ' . $poll->region->name;
        }

        if ($poll->scope === 'provincial' && $poll->province) {
            $ubicacion = 'Región: ' . $poll->region?->name . ' - Provincia: ' . $poll->province->name;
        }

        if ($poll->scope === 'distrital' && $poll->district) {
            $ubicacion = 'Región: ' . $poll->region?->name . ' - Provincia: ' . $poll->province?->name . ' - Distrito: ' . $poll->district->name;
        }

        $scopeLabel = match ($poll->scope) {
            'nacional' => 'Nacional',
            'regional' => 'Regional',
            'provincial' => 'Provincial',
            'distrital' => 'Distrital',
            default => 'No definido',
        };

        $totalVotosValidos = $poll->votes()
            ->where('vote_type', 'válido')
            ->count();

        $votosNoSabe = $poll->votes()
            ->where('vote_type', 'no sabe')
            ->count();

        $votosNinguno = $poll->votes()
            ->where('vote_type', 'ninguno')
            ->count();

        $totalVotos = $totalVotosValidos + $votosNoSabe + $votosNinguno;

        $candidatos = $poll->candidates()
            ->with('politicalParty')
            ->get()
            ->map(function ($candidate) use ($totalVotos) {
                $votos = $candidate->votes()->where('vote_type', 'válido')->count();
                $porcentaje = $totalVotos > 0 ? round(($votos / $totalVotos) * 100, 2) : 0;

                return [
                    'nombre' => $candidate->name,
                    'partido' => $candidate->politicalParty->name,
                    'partido_acronimo' => $candidate->politicalParty->acronym,
                    'votos' => $votos,
                    'porcentaje' => $porcentaje,
                    'color' => $candidate->politicalParty->color,
                    'foto' => $candidate->photo ? Storage::disk('candidates_photos')->path($candidate->photo) : null,
                    'partido_logo' => $candidate->politicalParty->logo ? Storage::disk('logos')->path($candidate->politicalParty->logo) : null,
                ];
            })
            ->sortByDesc('votos')
            ->values()
            ->toArray();

        return [
            'poll' => $poll,
            'scope_label' => $scopeLabel,
            'ubicacion_detalle' => $ubicacion,
            'candidatos' => $candidatos,
            'votos_no_sabe' => $votosNoSabe,
            'votos_ninguno' => $votosNinguno,
            'total_votos' => $totalVotos,
            'porcentaje_no_sabe' => $totalVotos > 0 ? round(($votosNoSabe / $totalVotos) * 100, 2) : 0,
            'porcentaje_ninguno' => $totalVotos > 0 ? round(($votosNinguno / $totalVotos) * 100, 2) : 0,
        ];
    }
}
