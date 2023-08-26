<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_name'        => fake()->name(),
            'exam_description' => fake()->paragraph(),
            'exam_type'        => 'it',
            'exam_duration'    => fake()->randomElement([1000 * 60 * 60, 1000 * 60 * 120]),
            'created_by'       => fake()->numberBetween(1, 3),
        ];
    }
}
