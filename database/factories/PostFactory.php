<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
 /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
 protected $_model = \App\Models\Post::class;
 public function definition(): array
 {
  return [
   "title"      => fake()->title(),
   "body"       => fake()->paragraph(),
   "created_at" => now(),
  ];
 }
}