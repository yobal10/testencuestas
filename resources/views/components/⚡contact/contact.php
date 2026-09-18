<?php

use App\Support\SiteSettings;
use Flux\Flux;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

new class extends Component
{
    #[Rule('required|string|max:100')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|string|max:150')]
    public string $subject = '';

    #[Rule('required|string|min:10')]
    public string $message = '';

    public function send()
    {
        $this->validate();

        Mail::raw(
            "Nombre: {$this->name}\nCorreo: {$this->email}\n\nMensaje:\n{$this->message}",
            function ($mail) {
                $mail->to(config('mail.from.address'))
                    ->subject("Contacto Web: {$this->subject}");
            }
        );

        $this->reset(['name', 'email', 'subject', 'message']);

        Flux::toast('Mensaje enviado correctamente. Te responderemos pronto.', variant: 'success');
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => 'Contacto' . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => 'Página de contacto del sitio web',
            ]);
    }
};
