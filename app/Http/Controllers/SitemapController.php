<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController
{
    public function __invoke()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/encuestas'))
            ->add(Url::create('/nosotros'))
            ->add(Url::create('/contacto'))
            ->add(Url::create('/como-funciona'))
            ->add(Url::create('/terminos-y-condiciones'));

        foreach (Survey::query()->whereIn('status', ['published', 'active'])->select(['id', 'slug', 'updated_at'])->cursor() as $survey) {
            $sitemap->add(Url::create(route('polls.show', ['survey' => $survey->slug]))
                ->setLastModificationDate($survey->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                ->setPriority(0.9));
        }

        return $sitemap;
    }
}