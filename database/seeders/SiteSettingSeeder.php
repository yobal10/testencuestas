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
                'site_name' => 'Campus Pulse University',
                'description' => 'Plataforma universitaria para encuestas académicas, mejora docente y experiencia estudiantil.',
                'image' => '01KGJJ1PAJ6DH6T07V1DG551JB.jpg',
                'email' => 'contacto@campuspulse.edu',
                'phone' => '+51 987 654 321',
                'address' => 'Av. Universitaria 245, Lima, Perú',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com',
            ]
        ]);
    }
}
