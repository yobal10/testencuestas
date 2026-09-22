<?php

use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $polls;

    public function mount(): void
    {
        $this->polls = Survey::query()
            ->whereIn('status', ['published', 'active'])
            ->withCount('responses')
            ->with(['faculty', 'program', 'period'])
            ->orderBy('responses_count', 'desc')
            ->latest()
            ->take(4)
            ->get();
        }
};
