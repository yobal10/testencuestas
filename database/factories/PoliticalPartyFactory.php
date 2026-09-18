<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PoliticalParty>
 */
class PoliticalPartyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        $acronym = strtoupper(substr($name, 0, 2) . substr(explode(' ', $name)[1] ?? '', 0, 1));

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'acronym' => $acronym,
            'logo' => 'https://picsum.photos/seed/' . fake()->numberBetween(1, 1000) . '/200/200',
            'color' => fake()->hexColor(),
            'description' => fake()->sentence(15),
        ];
    }

    public function withLogo()
    {
        return $this->state(fn(array $attributes) => [
            'logo' => 'https://picsum.photos/seed/' . fake()->numberBetween(1, 1000) . '/200/200',
        ]);
    }
}
