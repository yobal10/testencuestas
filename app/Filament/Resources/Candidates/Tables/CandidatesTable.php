<?php

namespace App\Filament\Resources\Candidates\Tables;

use App\Filament\Exports\CandidateExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombres y Apellidos')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('candidates_photos')
                    ->circular(),

                TextColumn::make('politicalParty.name')
                    ->label('Partido Político')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('poll.title')
                    ->label('Encuesta')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('number')
                    ->label('Número')
                    ->numeric()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Creado El')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado El')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('poll')
                    ->label('Encuesta')
                    ->relationship('poll', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('politicalParty')
                    ->label('Partido Político')
                    ->relationship('politicalParty', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(CandidateExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
