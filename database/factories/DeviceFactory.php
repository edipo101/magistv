<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\Plan;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
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
            'name' => fake()->name,
            'phone' => fake()->e164PhoneNumber,
            'account_id' => Account::inRandomOrder()->value('id'),
            'plan_id' => $plan->id,
            'started_at' => Carbon::create($date),
            'finished_at' => Carbon::create($date)->addMonths($plan->months),
            'active' => true
        ];
    }
}
