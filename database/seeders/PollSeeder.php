<?php

namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            ['id' => 1, 'departamento' => 'AMAZONAS'],
            ['id' => 2, 'departamento' => 'ANCASH'],
            ['id' => 3, 'departamento' => 'APURIMAC'],
            ['id' => 4, 'departamento' => 'AREQUIPA'],
            ['id' => 5, 'departamento' => 'AYACUCHO'],
            ['id' => 6, 'departamento' => 'CAJAMARCA'],
            ['id' => 7, 'departamento' => 'CALLAO'],
            ['id' => 8, 'departamento' => 'CUSCO'],
            ['id' => 9, 'departamento' => 'HUANCAVELICA'],
            ['id' => 10, 'departamento' => 'HUANUCO'],
            ['id' => 11, 'departamento' => 'ICA'],
            ['id' => 12, 'departamento' => 'JUNIN'],
            ['id' => 13, 'departamento' => 'LA LIBERTAD'],
            ['id' => 14, 'departamento' => 'LAMBAYEQUE'],
            ['id' => 15, 'departamento' => 'LIMA'],
            ['id' => 16, 'departamento' => 'LORETO'],
            ['id' => 17, 'departamento' => 'MADRE DE DIOS'],
            ['id' => 18, 'departamento' => 'MOQUEGUA'],
            ['id' => 19, 'departamento' => 'PASCO'],
            ['id' => 20, 'departamento' => 'PIURA'],
            ['id' => 21, 'departamento' => 'PUNO'],
            ['id' => 22, 'departamento' => 'SAN MARTIN'],
            ['id' => 23, 'departamento' => 'TACNA'],
            ['id' => 24, 'departamento' => 'TUMBES'],
            ['id' => 25, 'departamento' => 'UCAYALI'],
        ];

        foreach ($departamentos as $depto) {
            $nombre = $depto['departamento'];
            $title = "Encuesta Elecciones Regionales de {$nombre} 2026";

            Poll::create([
                'user_id' => 1,
                'category_id' => 3,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => null,
                'scope' => 'regional',
                'region_id' => $depto['id'],
                'province_id' => null,
                'district_id' => null,
                'image' => null,
                'status' => 'activo',
                'starts_at' => now(),
                'ends_at' => now()->addMonths(3),
            ]);
        }
    }
}
