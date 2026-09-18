<?php

namespace Database\Factories;

use App\Models\PoliticalParty;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'poll_id' => Poll::inRandomOrder()->first()->id,
            'political_party_id' => PoliticalParty::inRandomOrder()->first()->id,
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'photo' => 'https://picsum.photos/seed/' . fake()->numberBetween(1, 1000) . '/200/200',
            'biography' => fake()->paragraphs(3, true),
            'number' => fake()->numberBetween(1, 20),
        ];
    }
}
