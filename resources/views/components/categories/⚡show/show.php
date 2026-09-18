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

    public ?Category $category;

    public string $search = '';

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    #[Computed]
    public function polls()
    {
        return $this->category->activePolls()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%");
            })
            ->withCount(['votes', 'candidates'])
            ->orderBy('votes_count', 'desc')
            ->latest()
            ->paginate(5);
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => $this->category->name . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => $this->category->description,
            ]);
    }
};
