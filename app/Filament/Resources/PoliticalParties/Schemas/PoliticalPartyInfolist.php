<?php

namespace App\Filament\Resources\PoliticalParties\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class PoliticalPartyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            // ->columns(12)
            ->components([
                // ImageEntry::make('logo')
                //     ->disk('logos')
                //     ->circular()
                //     ->columnSpan(3),

                // TextEntry::make('name')
                //     ->label('Nombre')
                //     ->weight(FontWeight::Bold)
                //     ->columnSpan(6),

                // TextEntry::make('acronym')
                //     ->label('Acrónimo')
                //     ->badge()
                //     ->columnSpan(3),

                // TextEntry::make('slug')
                //     ->label('Slug')
                //     ->copyable()
                //     ->columnSpan(6),

                // ColorEntry::make('color')
                //     ->label('Color principal')
                //     ->columnSpan(4),

                // TextEntry::make('description')
                //     ->label('Descripción')
                //     ->markdown()
                //     ->columnSpanFull(),
            ]);
    }
}
