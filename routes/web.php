<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::livewire('/', 'home')->name('home');
Route::livewire('/encuestas', 'polls.index')->name('polls');
Route::livewire('/encuestas/{poll:slug}', 'polls.show')->name('polls.show');
Route::livewire('/partidos-politicos', 'parties.index')->name('parties');
Route::livewire('/partidos-politicos/{politicalParty:slug}', 'parties.show')->name('parties.show');
Route::livewire('/partidos-politicos/{politicalParty:slug}/candidato/{candidate:slug}', 'parties.candidate')->name('parties.candidate');
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
        ->add(Url::create('/partidos-politicos'))
        ->add(Url::create('/nosotros'))
        ->add(Url::create('/contacto'))
        ->add(Url::create('/como-funciona'))
        ->add(Url::create('/terminos-y-condiciones'));

    foreach (App\Models\Poll::actives()->select(['id', 'slug', 'updated_at'])->cursor() as $poll) {
        $sitemap->add(Url::create(route('polls.show', $poll))
            ->setLastModificationDate($poll->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
            ->setPriority(0.9));
    }

    foreach (App\Models\PoliticalParty::query()->select(['id', 'slug', 'updated_at'])->cursor() as $party) {
        $sitemap->add(Url::create(route('parties.show', $party))
            ->setLastModificationDate($party->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));

        foreach (App\Models\Candidate::query()
                ->where('political_party_id', $party->id)
                ->select(['id', 'slug', 'updated_at', 'political_party_id'])
                ->cursor() as $candidate)
        {
            $sitemap->add(Url::create(route('parties.candidate', ['politicalParty' => $party, 'candidate' => $candidate]))
                ->setLastModificationDate($candidate->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.6));
        }
    }

    return $sitemap;
});
