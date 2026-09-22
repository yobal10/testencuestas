<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::livewire('/', 'home')->name('home');
Route::livewire('/encuestas', 'polls.index')->name('polls');
Route::livewire('/encuestas/{survey:slug}', 'surveys.show')->name('polls.show');
Route::livewire('/contacto', 'contact')->name('contact');
Route::livewire('/nosotros', 'about')->name('about');
Route::livewire('/como-funciona', 'how_it_works')->name('how-it-works');

Route::view('/politicas-de-privacidad', 'policies.privacy-policy')->name('privacy-policy');
Route::view('/terminos-y-condiciones', 'policies.consent-terms')->name('consent-terms');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/encuestas'))
        ->add(Url::create('/nosotros'))
        ->add(Url::create('/contacto'))
        ->add(Url::create('/como-funciona'))
        ->add(Url::create('/terminos-y-condiciones'));

    foreach (App\Models\Survey::whereIn('status', ['published', 'active'])->select(['id', 'slug', 'updated_at'])->cursor() as $survey) {
        $sitemap->add(Url::create(route('polls.show', $survey))
            ->setLastModificationDate($survey->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
            ->setPriority(0.9));
    }

    return $sitemap;
});
