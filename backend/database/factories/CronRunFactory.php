<?php

namespace Database\Factories;

use App\Models\CronRun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CronRun>
 */
class CronRunFactory extends Factory
{
    protected $model = CronRun::class;

    public function definition(): array
    {
        return [
            'job_name'   => $this->faker->word(),
            'started_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'finished_at'=> $this->faker->dateTimeBetween('now', '+1 day'),
            'status'     => $this->faker->randomElement(['started', 'finished', 'failed']),
            'message'    => $this->faker->optional()->sentence(),
        ];
    }
}
