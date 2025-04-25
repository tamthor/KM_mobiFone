<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('tags')->insert([
                'title' => ucfirst($faker->unique()->word),
                'hit' => $faker->numberBetween(0, 100),
                'status' => $faker->randomElement(['active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
