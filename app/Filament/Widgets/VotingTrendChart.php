<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class VotingTrendChart extends ChartWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected ?string $heading = 'Respuestas de los últimos 7 días';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $last7Days = collect(range(6, 0))->map(function (int $daysAgo): array {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'date' => $date->format('d/m'),
                'responses' => SurveyResponse::query()
                    ->where('status', 'submitted')
                    ->whereDate('submitted_at', $date)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Encuestas respondidas',
                    'data' => $last7Days->pluck('responses')->toArray(),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $last7Days->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
