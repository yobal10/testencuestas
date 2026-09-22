<?php

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Support\SiteSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

new class extends Component
{
    public Survey $survey;
    public array $answers = [];
    public bool $submitted = false;

    public function mount(Survey $survey): void
    {
        abort_unless(in_array($survey->status, ['published', 'active'], true), 404);

        $this->survey = $survey->load(['faculty', 'program', 'period', 'questions']);
    }

    public function submit(): void
    {
        if ($this->submitted) {
            return;
        }

        $rules = [];

        foreach ($this->survey->questions as $question) {
            $rules["answers.{$question->id}"] = $question->is_required ? ['required'] : ['nullable'];
        }

        $this->validate($rules);

        $respondentId = $this->survey->is_anonymous ? null : auth()->id();

        if ($respondentId && SurveyResponse::where('survey_id', $this->survey->id)
            ->where('respondent_id', $respondentId)
            ->exists()) {
            $this->addError('submission', 'Ya registramos una respuesta para esta encuesta.');

            return;
        }

        DB::transaction(function () use ($respondentId): void {
            $response = SurveyResponse::create([
                'survey_id' => $this->survey->id,
                'respondent_id' => $respondentId,
                'response_token' => (string) Str::uuid(),
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

            foreach ($this->survey->questions as $question) {
                $value = $this->answers[$question->id] ?? null;

                if ($value === null || $value === '') {
                    continue;
                }

                $response->answers()->create([
                    'question_id' => $question->id,
                    'answer_text' => $question->question_type === 'text' ? trim((string) $value) : null,
                    'answer_numeric' => is_numeric($value) ? $value : null,
                ]);
            }
        });

        $this->submitted = true;
    }

    public function render(): View
    {
        return $this->view()->layout('layouts::app', [
            'title' => $this->survey->title . ' - ' . SiteSettings::get('site_name', config('app.name')),
            'description' => $this->survey->description,
        ]);
    }
};
