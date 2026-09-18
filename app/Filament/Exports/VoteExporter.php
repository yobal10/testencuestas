<?php

namespace App\Filament\Exports;

use App\Models\Vote;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class VoteExporter extends Exporter
{
    protected static ?string $model = Vote::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('code')
                ->label('Código'),
            ExportColumn::make('poll.title')
                ->label('Encuesta'),
            ExportColumn::make('candidate.name')
                ->label('Candidato'),
            ExportColumn::make('vote_type')
                ->label('Tipo de voto'),
            ExportColumn::make('ip_address')
                ->label('Dirección IP'),
            ExportColumn::make('user_agent')
                ->label('User Agent'),
            ExportColumn::make('created_at')
                ->label('Creado el'),
            ExportColumn::make('is_suspicious')
                ->label('Es sospechoso?')
                ->formatStateUsing(fn ($state) => $state ? 'Sí' : 'No'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación se ha completado exitosamente. Se exportaron ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
