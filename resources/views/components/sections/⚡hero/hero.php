<?php

use App\Models\AcademicProgram;
use App\Models\Faculty;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use Livewire\Component;

new class extends Component
{
    public int $totalSurveys = 0;
    public int $totalParticipants = 0;
    public int $totalResponses = 0;
    public int $totalFaculties = 0;
    public int $totalPrograms = 0;

    public function mount(): void
    {
        $this->totalSurveys = Survey::whereIn('status', ['published', 'active'])->count();
        $this->totalParticipants = User::count();
        $this->totalResponses = SurveyResponse::where('status', 'submitted')->count();
        $this->totalFaculties = Faculty::where('is_active', true)->count();
        $this->totalPrograms = AcademicProgram::where('is_active', true)->count();
    }
};
