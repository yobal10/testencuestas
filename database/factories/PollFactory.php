<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(3, true),
            'image' => 'https://picsum.photos/seed/' . fake()->numberBetween(1, 1000) . '/200/200',
            'status' => 'activo',
            'starts_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'ends_at' => fake()->dateTimeBetween('now', '+4 months'),
        ];
    }

    public function active()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'activo',
            'starts_at' => now()->subDays(1),
            'ends_at' => now()->addMonths(1),
        ]);
    }

    public function closed()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'cerrado',
            'ends_at' => now()->subDays(1),
        ]);
    }
}
