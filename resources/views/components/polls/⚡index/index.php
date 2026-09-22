<?php

use App\Models\AcademicProgram;
use App\Models\Faculty;
use App\Models\Survey;
use App\Support\SiteSettings;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public string $search = '';

    public ?int $facultyId = null;
    public ?int $programId = null;

    public function updatedScope()
    {
        $this->reset('programId');
    }

    public function updatedFacultyId()
    {
        $this->reset('programId');
    }

    #[Computed]
    public function faculties()
    {
        return Faculty::where('is_active', true)->orderBy('name')->pluck('name', 'id');
    }

    #[Computed]
    public function programs()
    {
        if (!$this->facultyId) return collect();
        return AcademicProgram::where('faculty_id', $this->facultyId)->where('is_active', true)->orderBy('name')->pluck('name', 'id');
    }

    #[Computed]
    public function surveys()
    {
        return Survey::query()->whereIn('status', ['published', 'active'])
            ->when($this->search, fn ($q) =>
                $q->where('title', 'like', "%{$this->search}%")
            )
            ->when($this->facultyId, fn ($q) => $q->where('faculty_id', $this->facultyId))
            ->when($this->programId, fn ($q) => $q->where('program_id', $this->programId))
            ->withCount('responses')->with(['faculty', 'program', 'period'])->orderByDesc('responses_count')
            ->latest()
            ->paginate(6);
    }

    public function resetFilters()
    {
        $this->reset(['facultyId', 'programId', 'search']);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => 'Encuestas' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Lista de encuestas disponibles donde podrás participar y conocer los resultados.',
            ]);
    }
};
