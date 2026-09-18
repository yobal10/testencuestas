<?php

namespace App\Filament\Widgets;

use App\Models\Poll;
use App\Models\User;
use App\Models\Vote;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ElectoralStatsOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;

    protected ?string $heading = 'Estadísticas Electorales';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activePolls = Poll::where('status', 'activo')->count();
        $totalVotes = Vote::count();
        $todayVotes = Vote::whereDate('created_at', today())->count();
        $registeredVotes = User::count();

        return [
            Stat::make('Encuestas Activas', $activePolls)
                ->description('En curso actualmente')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('success'),


            Stat::make('Total de Votos', number_format($totalVotes))
                ->description($todayVotes . ' votos hoy')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('primary'),

            Stat::make('Votantes Registrados', number_format($registeredVotes))
                ->description('Usuarios totales')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Participación Hoy', $todayVotes)
                ->description('Votos en las últimas 24 horas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),


        ];
    }
}
