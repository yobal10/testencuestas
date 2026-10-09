<?php

use App\Support\SiteSettings;
use Illuminate\View\View;
use Livewire\Component;

new class extends Component
{
    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => 'Comunidad académica - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Comunidad académica y participación universitaria.',
            ]);
    }
};