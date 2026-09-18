<?php

namespace App\Filament\Exports;

use App\Models\PoliticalParty;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PoliticalPartyExporter extends Exporter
{
    protected static ?string $model = PoliticalParty::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label('Nombre'),
            ExportColumn::make('slug'),
            ExportColumn::make('acronym')
                ->label('Acrónimo'),
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
