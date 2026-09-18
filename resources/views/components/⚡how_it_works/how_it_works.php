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
                'title' => 'Cómo funciona' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Cómo funciona el sitio web ' . SiteSettings::get('site_name', config('app.name')) . ' y qué servicios ofrecemos a nuestros usuarios.',
            ]);
    }
};
