<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = Plan::inRandomOrder()->first();
        $date = Carbon::createFromDate(null, fake()->numberBetween(1, 7), fake()->numberBetween(1, 30));
        return [
            'username' => Str::random(10),
            'plan_id' => $plan->id,
            'started_at' => Carbon::create($date),
            'finished_at' => Carbon::create($date)->addMonths($plan->months)
        ];
    }
}
