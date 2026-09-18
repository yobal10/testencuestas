<?php

namespace Database\Seeders;

use App\Models\SiteSetting as ModelsSiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsSiteSetting::create([
            'data' => [
                'site_name' => 'Sistema de Encuestas Electorales 2026',
                'description' => 'Plataforma para la gestión de encuestas electorales.',
                'image' => '01KGJJ1PAJ6DH6T07V1DG551JB.jpg',
                'email' => 'contacto@example.com',
                'phone' => '+51 123 456 789',
                'address' => 'Av. Principal 123, Ciudad, País',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com',
            ]
        ]);
    }
}
