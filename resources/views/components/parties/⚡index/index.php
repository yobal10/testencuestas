<?php

use App\Models\PoliticalParty;
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

    #[Computed]
    public function politicalParties()
    {
        return PoliticalParty::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->orderBy('name')
            ->paginate(8);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => 'Partidos Políticos' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Lista de partidos políticos',
            ]);
    }
};
