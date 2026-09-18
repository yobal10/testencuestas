<?php

namespace App\Filament\Widgets;

use App\Models\Vote;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class VoteTypeChart extends ChartWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected ?string $heading = 'Distribución de Votos por Tipo';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $voteTypes = Vote::selectRaw('vote_type, COUNT(*) as count')
            ->groupBy('vote_type')
            ->pluck('count', 'vote_type')
            ->toArray();

        $labels = [
            'válido' => 'Voto por Candidato',
            'no sabe' => 'Voto indeciso',
            'ninguno' => 'Voto ninguno',
        ];

        $data = [];
        $displayLabels = [];

        foreach ($labels as $key => $label) {
            $data[] = $voteTypes[$key] ?? 0;
            $displayLabels[] = $label;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Votos',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(156, 163, 175)',
                        'rgb(239, 68, 68)',
                    ],
                ],
            ],
            'labels' => $displayLabels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
