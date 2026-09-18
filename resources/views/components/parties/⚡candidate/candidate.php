<?php

use App\Models\Candidate;
use App\Support\SiteSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

new class extends Component
{
    public Candidate $candidate;

    public function mount(Candidate $candidate): void
    {
        $this->candidate = $candidate->load(['politicalParty', 'poll']);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => $this->candidate->name . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => $this->candidate->biography,
                'image' => $this->candidate->photo ? Storage::disk('candidates_photos')->url($this->candidate->photo) : null,
            ]);
    }
};
