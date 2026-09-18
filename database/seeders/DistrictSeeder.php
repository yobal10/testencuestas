<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/3_ubigeo_distritos.json'));
        $data = json_decode($json, true);

        $districts = collect($data['ubigeo_distritos'])->map(function ($item) {
            $provinceId = DB::table('provinces')
                ->where('id', $item['provincia_id'])
                ->value('id');

            return [
                'province_id' => $provinceId,
                'name' => $item['distrito'],
                'code' => $item['ubigeo'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('districts')->insert($districts);
    }
}
