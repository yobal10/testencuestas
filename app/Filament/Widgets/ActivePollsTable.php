<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActivePollsTable extends TableWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected static ?string $heading = 'Encuestas universitarias';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder =>
            Survey::query()
                ->availableForResponses()
                ->withCount(['responses' => fn ($query) => $query->where('status', 'submitted')])
                ->orderByDesc('responses_count'))
            ->columns([
                TextColumn::make('title')
                    ->label('Encuesta')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('survey_type_label')
                    ->label('Tipo de evaluación')
                    ->badge(),

                TextColumn::make('period.name')
                    ->label('Periodo académico')
                    ->placeholder('Sin periodo asignado'),

                TextColumn::make('responses_count')
                    ->label('Respuestas')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('closes_at')
                    ->label('Finaliza')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Sin fecha'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Publicada',
                        'active' => 'Activa',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'published', 'active' => 'success',
                        'draft' => 'gray',
                        'closed' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('responses_count', 'desc')
            ->recordUrl(fn (Survey $record): string => \App\Filament\Resources\Surveys\SurveyResource::getUrl('edit', ['record' => $record]));
    }
}
