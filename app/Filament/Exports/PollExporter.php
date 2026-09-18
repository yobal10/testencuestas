<?php

namespace App\Filament\Exports;

use App\Models\Poll;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PollExporter extends Exporter
{
    protected static ?string $model = Poll::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('title')
                ->label('Título'),
            ExportColumn::make('category.name'),
            ExportColumn::make('slug'),
            ExportColumn::make('scope')
                ->label('Ambito'),
            ExportColumn::make('region.name')
                ->label('Región'),
            ExportColumn::make('province.name')
                ->label('Provincia'),
            ExportColumn::make('district.name')
                ->label('Distrito'),
            ExportColumn::make('status')
                ->label('Estado'),
            ExportColumn::make('starts_at')
                ->label('Empieza en'),
            ExportColumn::make('ends_at')
                ->label('Finaliza en'),
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
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
