<?php

use App\Models\District;
use App\Models\Poll;
use App\Models\Province;
use App\Models\Region;
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

    public ?string $scope = null;
    public ?int $regionId = null;
    public ?int $provinceId = null;
    public ?int $districtId = null;

    public function updatedScope()
    {
        $this->reset(['regionId', 'provinceId', 'districtId']);
    }

    public function updatedRegionId()
    {
        $this->reset(['provinceId', 'districtId']);
    }

    public function updatedProvinceId()
    {
        $this->reset('districtId');
    }

    #[Computed]
    public function regions()
    {
        return Region::orderBy('name')->pluck('name', 'id');
    }

    #[Computed]
    public function provinces()
    {
        if (!$this->regionId) return collect();
        return Province::where('region_id', $this->regionId)->orderBy('name')->pluck('name', 'id');
    }

    #[Computed]
    public function districts()
    {
        if (!$this->provinceId) return collect();
        return District::where('province_id', $this->provinceId)->orderBy('name')->pluck('name', 'id');
    }

    #[Computed]
    public function polls()
    {
        return Poll::actives()
            ->when($this->search, fn ($q) =>
                $q->where('title', 'like', "%{$this->search}%")
            )
            ->when($this->scope, fn ($q) =>
                $q->where('scope', $this->scope)
            )
            ->when($this->regionId, fn ($q) =>
                $q->where('region_id', $this->regionId)
            )
            ->when($this->provinceId, fn ($q) =>
                $q->where('province_id', $this->provinceId)
            )
            ->when($this->districtId, fn ($q) =>
                $q->where('district_id', $this->districtId)
            )
            ->withCount('votes')
            ->with(['category', 'candidates', 'region', 'province', 'district'])
            ->orderByDesc('votes_count')
            ->latest()
            ->paginate(6);
    }

    public function resetFilters()
    {
        $this->reset(['scope', 'regionId', 'provinceId', 'districtId', 'search']);
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
