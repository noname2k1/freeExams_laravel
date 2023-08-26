<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'option_text' => fake()->sentence(),
            'is_true'     => false,
            // 'question_id' => fake()->numberBetween(1, 10),
            'question_id' => 6,
        ];
    }
}
