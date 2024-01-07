<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 2),
            'word_en' => $this->faker->unique->word,
            'word_ja' => $this->faker->word,
            'part_of_speech' => $this->faker->numberBetween(0, 4),
            'memory' => $this->faker->numberBetween(0, 2),
            'memo' => $this->faker->text,
        ];
    }
}
