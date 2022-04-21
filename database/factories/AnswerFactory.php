<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $table = \App\Models\Answer::class;
    public function definition()
    {
        return [
            'text' =>  $this->faker->word(),
            'question_id' => '66',
            'is_correct' => 'false'
        ];
    }
}