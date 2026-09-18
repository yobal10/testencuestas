<?php

namespace App\Filament\Widgets;

use App\Models\Poll;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActivePollsTable extends TableWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected static ?string $heading = 'Encuestas Activas';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder =>
            Poll::query()
                ->where('status', 'activo')
                ->withCount('votes')
                ->orderBy('votes_count', 'desc'))
            ->columns([
                TextColumn::make('title')
                    ->label('Encuesta')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->badge(),

                TextColumn::make('votes_count')
                    ->label('Total Votos')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('ends_at')
                    ->label('Finaliza')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'activo' => 'success',
                        'borrador' => 'info',
                        'cerrado' => 'danger',
                        'archivado' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
