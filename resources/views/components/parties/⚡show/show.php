<?php

use App\Models\PoliticalParty;
use App\Support\SiteSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public ?PoliticalParty $politicalParty;

    public function mount(PoliticalParty $politicalParty): void
    {
        $this->politicalParty = $politicalParty;
    }

    #[Computed]
    public function candidates()
    {
        return $this->politicalParty?->candidates()->paginate(6);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => $this->politicalParty->name . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => $this->politicalParty->description,
                'image' => $this->politicalParty->logo ? Storage::disk('logos')->url($this->politicalParty->logo) : null,
            ]);
    }
};
