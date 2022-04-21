<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $table = \App\Models\Question::class;
    public function definition()
    {
        return [
            'text' => $this->faker->name() . $this->faker->words(),
            'quiz_id' => 71,
        ];
    }
}