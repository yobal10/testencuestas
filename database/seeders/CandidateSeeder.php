<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidatesData = [
            [
                'poll_id' => 3,
                'name' => 'Marco Antonio Palacios Rodríguez',
                'political_party_id' => 1,
                'number' => 1,
            ],
            [
                'poll_id' => 3,
                'name' => 'Carlos Alberto Mendoza Castillo',
                'political_party_id' => 3,
                'number' => 2,
            ],
            [
                'poll_id' => 3,
                'name' => 'Luis Fernando Quispe Huamán',
                'political_party_id' => 2,
                'number' => 3,
            ],
            [
                'poll_id' => 3,
                'name' => 'Rosa María Paredes Cano',
                'political_party_id' => 8,
                'number' => 4,
            ],
            [
                'poll_id' => 3,
                'name' => 'Jorge Raúl Tapia Flores',
                'political_party_id' => 4,
                'number' => 5,
            ],

            [
                'poll_id' => 8,
                'name' => 'Ricardo Manuel Cáceres Valdivia',
                'political_party_id' => 6,
                'number' => 1,
            ],
            [
                'poll_id' => 8,
                'name' => 'Patricia Elena Sánchez Yupanqui',
                'political_party_id' => 1,
                'number' => 2,
            ],
            [
                'poll_id' => 8,
                'name' => 'Edgar Martín Quispe Ccama',
                'political_party_id' => 2,
                'number' => 3,
            ],
            [
                'poll_id' => 8,
                'name' => 'Ana Lucía Vargas Condori',
                'political_party_id' => 10,
                'number' => 4,
            ],
            [
                'poll_id' => 8,
                'name' => 'Fernando José Huamán Ttito',
                'political_party_id' => 3,
                'number' => 5,
            ],

            [
                'poll_id' => 15,
                'name' => 'Rafael Enrique López Silva',
                'political_party_id' => 6,
                'number' => 1,
            ],
            [
                'poll_id' => 15,
                'name' => 'María Teresa Gonzales Díaz',
                'political_party_id' => 1,
                'number' => 2,
            ],
            [
                'poll_id' => 15,
                'name' => 'Juan Carlos Fernández Rojas',
                'political_party_id' => 8,
                'number' => 3,
            ],
            [
                'poll_id' => 15,
                'name' => 'Carmen Rosa Vega Morales',
                'political_party_id' => 5,
                'number' => 4,
            ],
            [
                'poll_id' => 15,
                'name' => 'Miguel Ángel Torres Herrera',
                'political_party_id' => 7,
                'number' => 5,
            ],
            [
                'poll_id' => 15,
                'name' => 'Sandra Liliana Castro Ramos',
                'political_party_id' => 3,
                'number' => 6,
            ],
        ];

        foreach ($candidatesData as $candidateData) {
            Candidate::create([
                'poll_id' => $candidateData['poll_id'],
                'political_party_id' => $candidateData['political_party_id'],
                'name' => $candidateData['name'],
                'slug' => Str::slug($candidateData['name']),
                'photo' => null,
                'biography' => null,
                'number' => $candidateData['number'],
            ]);
        }
    }
}
