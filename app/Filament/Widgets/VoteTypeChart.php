<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class VoteTypeChart extends ChartWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;
    protected ?string $heading = 'Respuestas por tipo de encuesta';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $surveyTypes = SurveyResponse::query()
            ->join('surveys', 'survey_responses.survey_id', '=', 'surveys.id')
            ->where('survey_responses.status', 'submitted')
            ->selectRaw('surveys.survey_type, COUNT(*) as total')
            ->groupBy('surveys.survey_type')
            ->pluck('total', 'surveys.survey_type')
            ->toArray();

        $labels = [
            'student_experience' => 'Experiencia estudiantil',
            'teacher_evaluation' => 'Evaluación docente',
            'course_evaluation' => 'Evaluación de cursos',
            'service_evaluation' => 'Servicios universitarios',
            'institutional' => 'Evaluación institucional',
        ];

        $data = [];
        $displayLabels = [];

        foreach ($labels as $key => $label) {
            $data[] = $surveyTypes[$key] ?? 0;
            $displayLabels[] = $label;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Respuestas enviadas',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(156, 163, 175)',
                        'rgb(239, 68, 68)',
                        'rgb(234, 179, 8)',
                        'rgb(16, 185, 129)',
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
