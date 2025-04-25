<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PromotionContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('promotion_contacts')->insert([
                'promotion_content_id' => $faker->numberBetween(1, 5),
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'city' => $faker->city,
                'note' => $faker->boolean(50) ? $faker->sentence : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
