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
                'title' => 'Nosotros' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Página de información sobre nosotros del sitio web',
            ]);
    }
};
