<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\UniversityMember;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ElectoralStatsOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;

    protected ?string $heading = 'Indicadores académicos';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activeSurveys = Survey::query()->availableForResponses()->count();
        $totalResponses = SurveyResponse::query()->where('status', 'submitted')->count();
        $todayResponses = SurveyResponse::query()->where('status', 'submitted')->whereDate('submitted_at', today())->count();
        $participants = UniversityMember::query()->where('status', 'active')->count();

        return [
            Stat::make('Encuestas disponibles', $activeSurveys)
                ->description('Publicadas para la comunidad')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('success'),

            Stat::make('Respuestas recibidas', number_format($totalResponses))
                ->description($todayResponses . ' respuestas hoy')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('primary'),

            Stat::make('Participantes activos', number_format($participants))
                ->description('Registrados en la comunidad')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Participación de hoy', $todayResponses)
                ->description('Encuestas respondidas hoy')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
