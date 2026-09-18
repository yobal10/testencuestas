<?php

namespace App\Filament\Resources\Votes\Tables;

use App\Filament\Exports\VoteExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),

                TextColumn::make('poll.title')
                    ->label('Encuesta')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('vote_type')
                    ->label('Tipo de Voto')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'válido' => 'success',
                        'no sabe' => 'warning',
                        'ninguno' => 'danger',
                        default => 'success',
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('vote_type')
                    ->label('Tipo de Voto')
                    ->options([
                        'válido' => 'Válido',
                        'no sabe' => 'No sabe / No opina',
                        'ninguno' => 'Ninguno de los anteriores',
                    ]),

                SelectFilter::make('poll')
                    ->label('Encuesta')
                    ->relationship('poll', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(VoteExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
