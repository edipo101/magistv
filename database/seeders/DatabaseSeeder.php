<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Device;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([PlanSeeder::class]);
        
        User::factory()->create([
        	'name' => 'Edwin Porco',
        	'username' => 'edipo',
        	'password' => 'okeymakey'
        ]);

        User::factory()->create([
        	'name' => 'Nelson Porco',
        	'username' => 'niel1991',
        	'password' => 'somosaire1991'
        ]);

        // Account::factory(10)->create();
        // Device::factory(20)->create();
    }
}
