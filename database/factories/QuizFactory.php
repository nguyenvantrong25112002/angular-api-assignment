<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class QuizFactory extends Factory
{
    protected $table = \App\Models\Quiz::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Quiz.' . $this->faker->numberBetween(1, 8),
            'subject_id' => \App\Models\Subject::all()->random()->id,
            'duration_minutes' => $this->faker->numberBetween(10, 15),
            'start_time' => Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
            'end_time' => Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
            'status' => $this->faker->numberBetween(0, 1),
            'is_shuffle' => $this->faker->numberBetween(0, 1),
        ];
    }
}