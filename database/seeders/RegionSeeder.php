<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/1_ubigeo_departamentos.json'));
        $data = json_decode($json, true);

        $regions = collect($data['ubigeo_departamentos'])->map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['departamento'],
                'code' => $item['ubigeo'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('regions')->insert($regions);
    }
}
