<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CandidateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombres y Apellidos'),

                TextEntry::make('poll.title')
                    ->label('Encuesta'),

                TextEntry::make('politicalParty.name')
                    ->label('Partido Político')
                    ->placeholder('-'),


                ImageEntry::make('photo')
                    ->label('Foto')
                    ->disk('candidates_photos')
                    ->circular()
                    ->placeholder('-'),

                TextEntry::make('biography')
                    ->label('Biografía')
                    ->formatStateUsing(fn(?string $state): string => $state ? nl2br(e($state)) : '-')
                    ->html()
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('number')
                    ->label('Número')
                    ->numeric()
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->date('d/m/Y H:i')
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->date('d/m/Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
