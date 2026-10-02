<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class TopCandidatesChart extends ChartWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected ?string $heading = 'Encuestas con más respuestas';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $topSurveys = Survey::query()
            ->withCount(['responses' => fn ($query) => $query->where('status', 'submitted')])
            ->orderByDesc('responses_count')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Respuestas',
                    'data' => $topSurveys->pluck('responses_count')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                    ],
                ],
            ],
            'labels' => $topSurveys->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
