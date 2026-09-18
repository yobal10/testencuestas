<?php

namespace App\Filament\Widgets;

use App\Models\Vote;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class TopCandidatesChart extends ChartWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected ?string $heading = 'Top 5 Candidatos Más Votados';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $topCandidates = Vote::where('vote_type', 'válido')
            ->selectRaw('candidate_id, COUNT(*) as votes')
            ->groupBy('candidate_id')
            ->orderByDesc('votes')
            ->limit(5)
            ->with('candidate')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Votos',
                    'data' => $topCandidates->pluck('votes')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                    ],
                ],
            ],
            'labels' => $topCandidates->map(
                fn($item) =>
                $item->candidate->name
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
