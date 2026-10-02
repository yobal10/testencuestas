<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

Route::livewire('/', 'home')->name('home');
Route::livewire('/encuestas', 'polls.index')->name('polls');
Route::livewire('/encuestas/{survey:slug}', 'surveys.show')->name('polls.show');
Route::livewire('/comunidad-academica', 'community')->name('community');
Route::livewire('/contacto', 'contact')->name('contact');
Route::livewire('/nosotros', 'about')->name('about');
Route::livewire('/como-funciona', 'how_it_works')->name('how-it-works');

Route::view('/politicas-de-privacidad', 'policies.privacy-policy')->name('privacy-policy');
Route::view('/terminos-y-condiciones', 'policies.consent-terms')->name('consent-terms');

Route::get('/sitemap.xml', SitemapController::class);
