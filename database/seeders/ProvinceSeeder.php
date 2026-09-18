<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/2_ubigeo_provincias.json'));
        $data = json_decode($json, true);

        $provinces = collect($data['ubigeo_provincias'])->map(function ($item) {
            $regionId = DB::table('regions')
                ->where('id', $item['departamento_id'])
                ->value('id');

            return [
                'region_id' => $regionId,
                'name' => $item['provincia'],
                'code' => $item['ubigeo'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('provinces')->insert($provinces);
    }
}
