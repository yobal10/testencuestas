<?php

namespace App\Filament\Resources\Polls\Schemas;

use App\Models\Poll;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PollInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Encuesta')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('category.name')->label('Categoría'),
                            TextEntry::make('title')->label('Título'),
                            TextEntry::make('slug'),
                            TextEntry::make('description')
                                ->label('Descripción')
                                ->formatStateUsing(fn(?string $state): string => $state ? nl2br(e($state)) : '-')
                                ->html()
                                ->columnSpanFull(),
                            ImageEntry::make('image')->disk('polls')->label('Imagen')->placeholder('-'),
                            TextEntry::make('status')->label('Estado')->badge(),
                            TextEntry::make('starts_at')->label('Fecha de inicio')->dateTime(),
                            TextEntry::make('ends_at')->label('Fecha de finalización')->dateTime('d/m/Y H:i'),
                            TextEntry::make('created_at')->label('Creado el')->dateTime('d/m/Y H:i'),
                            TextEntry::make('updated_at')->label('Actualizado el')->dateTime('d/m/Y H:i'),
                        ]),
                    ])->columnSpanFull(),

                Section::make('Ámbito Geográfico')
                    ->schema([
                        Grid::make(2)->schema([

                            TextEntry::make('scope')
                                ->label('Ámbito')
                                ->formatStateUsing(fn($state) => match ($state) {
                                    'nacional' => 'Nacional',
                                    'regional' => 'Regional',
                                    'provincial' => 'Provincial',
                                    'distrital' => 'Distrital',
                                    default => '-',
                                })
                                ->badge()
                                ->color(fn($state) => match ($state) {
                                    'nacional' => 'primary',
                                    'regional' => 'info',
                                    'provincial' => 'warning',
                                    'distrital' => 'danger',
                                    default => 'gray',
                                }),

                            TextEntry::make('region.name')
                                ->label('Región')
                                ->visible(fn(Poll $record) => in_array($record->scope, ['regional', 'provincial', 'distrital']))
                                ->placeholder('-'),

                            TextEntry::make('province.name')
                                ->label('Provincia')
                                ->visible(fn(Poll $record) => in_array($record->scope, ['provincial', 'distrital']))
                                ->placeholder('-'),

                            TextEntry::make('district.name')
                                ->label('Distrito')
                                ->visible(fn(Poll $record) => $record->scope === 'distrital')
                                ->placeholder('-'),

                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Resumen de Votación')
                    ->schema([
                        Grid::make(4)->schema([
                            TextEntry::make('total_votes')
                                ->label('Votos Totales')
                                ->state(fn(Poll $record) => $record->votes()->count())
                                ->badge()
                                ->color('primary'),

                            TextEntry::make('candidate_votes')
                                ->label('Votos a Candidatos')
                                ->state(
                                    fn(Poll $record) =>
                                    $record->votes()->where('vote_type', 'válido')->count()
                                )
                                ->badge()
                                ->color('success'),

                            TextEntry::make('know_vote')
                                ->label('No Sabe / No Opina')
                                ->state(
                                    fn(Poll $record) =>
                                    $record->votes()->where('vote_type', 'no sabe')->count()
                                )
                                ->badge()
                                ->color('gray'),

                            TextEntry::make('none_vote')
                                ->label('Ninguno')
                                ->state(
                                    fn(Poll $record) =>
                                    $record->votes()->where('vote_type', 'ninguno')->count()
                                )
                                ->badge()
                                ->color('warning'),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Resultados por Candidato')
                    ->schema([
                        RepeatableEntry::make('candidates')
                            ->label('Candidatos')
                            ->schema([
                                Grid::make(5)->schema([
                                    ImageEntry::make('photo')
                                        ->label('Foto')
                                        ->disk('candidates_photos')
                                        ->circular()
                                        ->imageSize(60),

                                    Grid::make(1)->schema([
                                        TextEntry::make('name')
                                            ->label('Candidato')
                                            ->weight('semibold'),

                                        TextEntry::make('politicalParty.name')
                                            ->label('Partido')
                                            ->color('gray')
                                            ->size('sm'),
                                    ])->columnSpan(2),

                                    TextEntry::make('votes_count')
                                        ->label('Votos')
                                        ->getStateUsing(function ($record, $component) {
                                            $poll = $component->getContainer()->getLivewire()->getRecord();
                                            return $record->votes()
                                                ->where('poll_id', $poll->id)
                                                ->count();
                                        })
                                        ->size('lg')
                                        ->weight('bold'),

                                    TextEntry::make('percentage')
                                        ->label('Porcentaje')
                                        ->getStateUsing(function ($record, $component) {
                                            $poll = $component->getContainer()->getLivewire()->getRecord();

                                            $total = $poll->votes()->count();

                                            if ($total === 0) return '0%';

                                            $votes = $record->votes()
                                                ->where('poll_id', $poll->id)
                                                ->count();

                                            return number_format(($votes / $total) * 100, 2) . ' %';
                                        })
                                        ->badge()
                                        ->color('info')
                                        ->size('lg'),
                                ]),
                            ])
                            ->contained(false)
                            ->columns(1),

                        Grid::make(5)->schema([
                            TextEntry::make('no_sabe_photo')
                                ->label('No Sabe / No Opina')
                                ->state(''),

                            Grid::make(1)->schema([
                                TextEntry::make('no_sabe_label')
                                    ->label('-')
                                    ->state('No sabe / No opina')
                                    ->weight('bold')
                                    ->color('gray'),
                            ])->columnSpan(2),

                            TextEntry::make('no_sabe_votes')
                                ->label('Votos')
                                ->state(fn(Poll $record) => $record->votes()->where('vote_type', 'no sabe')->count())
                                ->size('lg')
                                ->weight('bold'),

                            TextEntry::make('no_sabe_percentage')
                                ->label('Porcentaje')
                                ->state(function (Poll $record) {
                                    $total = $record->votes()->count();
                                    if ($total === 0) return '0%';

                                    $votes = $record->votes()->where('vote_type', 'no sabe')->count();
                                    return number_format(($votes / $total) * 100, 2) . ' %';
                                })
                                ->badge()
                                ->color('gray')
                                ->size('lg'),
                        ]),

                        Grid::make(5)->schema([
                            TextEntry::make('ninguno_photo')
                                ->label('Ninguno de los anteriores')
                                ->label('')
                                ->state(''),

                            Grid::make(1)->schema([
                                TextEntry::make('ninguno_label')
                                    ->label('-')
                                    ->state('Ninguno')
                                    ->weight('bold')
                                    ->color('warning')
                            ])->columnSpan(2),

                            TextEntry::make('ninguno_votes')
                                ->label('Votos')
                                ->state(fn(Poll $record) => $record->votes()->where('vote_type', 'ninguno')->count())
                                ->size('lg')
                                ->weight('bold'),

                            TextEntry::make('ninguno_percentage')
                                ->label('Porcentaje')
                                ->state(function (Poll $record) {
                                    $total = $record->votes()->count();
                                    if ($total === 0) return '0%';

                                    $votes = $record->votes()->where('vote_type', 'ninguno')->count();
                                    return number_format(($votes / $total) * 100, 2) . ' %';
                                })
                                ->badge()
                                ->color('warning')
                                ->size('lg'),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
