<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
        	'name' => '1M',
        	'description' => '1 mes',
        	'months' => 1,
        	'price' => 20
        ]);

        Plan::create([
            'name' => '3M',
            'description' => '3 meses + 1',
            'months' => 4,
            'price' => 60
        ]);

        Plan::create([
            'name' => '6M',
            'description' => '6 meses + 3',
            'months' => 9,
            'price' => 120
        ]);

        Plan::create([
            'name' => '1A',
            'description' => '1 año + 5 meses',
            'months' => 17,
            'price' => 240
        ]);
    }
}
