<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettings
{
    public static function all(): array
    {
        return Cache::rememberForever('site_settings', function () {
            return SiteSetting::first()?->data ?? [];
        });
    }

    public static function get(string $key, $default = null)
    {
        return data_get(static::all(), $key, $default);
    }

    public static function clear(): void
    {
        Cache::forget('site_settings');
    }
}
