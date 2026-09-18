<?php

namespace App\Filament\Resources\Polls\Tables;

use App\Filament\Exports\PollExporter;
use App\Models\Poll;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->numeric()
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('image')
                    ->disk('polls')
                    ->label('Imagen'),

                TextColumn::make('scope')
                    ->label('Ámbito')
                    ->searchable(),

                SelectColumn::make('status')
                    ->label('Estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'activo' => 'Activo',
                        'cerrado' => 'Cerrado',
                        'archivado' => 'Archivado',
                    ])
                    ->selectablePlaceholder(false)
                    ->disabled(fn() => !auth()->user()->can('Update:Poll'))
                    ->afterStateUpdated(function ($record, $state) {
                        $record->update(['status' => $state]);

                        Notification::make()
                            ->title('Estado actualizado')
                            ->success()
                            ->send();
                    }),

                TextColumn::make('ends_at')
                    ->label('Finalización')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('scope')
                    ->label('Ámbito')
                    ->options([
                        'nacional' => 'Nacional',
                        'regional' => 'Regional',
                        'provincial' => 'Provincial',
                        'distrital' => 'Distrital',
                    ]),

                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'activo' => 'Activo',
                        'cerrado' => 'Cerrado',
                        'archivado' => 'Archivado',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('exportPdf')
                    ->label('Exportar PDF')
                    ->icon(Heroicon::DocumentArrowDown)
                    ->color('sucess')
                    ->action(function (Poll $record) {
                        return response()->streamDownload(function () use ($record) {
                            $data = self::getPollData($record);

                            $pdf = Pdf::loadView('pdf.poll-results', $data);

                            echo $pdf->output();
                        }, 'resultados-' . $record->slug . '.pdf');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Exportar resultados')
                    ->modalDescription('¿Deseas exportar los resultados de esta encuesta?')
                    ->modalSubmitActionLabel('Exportar')
            ])
            ->headerActions([
                ExportAction::make()->exporter(PollExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    protected static function getPollData(Poll $poll): array
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
