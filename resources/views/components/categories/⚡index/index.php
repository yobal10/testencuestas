<?php

use App\Models\Category;
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
    public function categories()
    {
        return Category::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->withCount('activePolls')
            ->orderBy('id', 'asc')
            ->paginate(8);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => 'Categorías' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Lista de categorías de encuestas',
            ]);
    }
};
