<?php

namespace App\Filament\Exports;

use App\Models\Candidate;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CandidateExporter extends Exporter
{
    protected static ?string $model = Candidate::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label('Nombres y Apellidos'),
            ExportColumn::make('poll.title')
                ->label('Encuesta'),
            ExportColumn::make('politicalParty.name')
                ->label('Partido Político'),
            ExportColumn::make('number')
                ->label('Número del Partido'),
            ExportColumn::make('created_at')
                ->label('Creado el'),
            ExportColumn::make('updated_at')
                ->label('Actualizado el'),
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
