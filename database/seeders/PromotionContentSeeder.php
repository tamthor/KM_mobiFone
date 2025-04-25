<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PromotionContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $onlineImages = collect(range(1, 10))->map(fn($i) => "https://picsum.photos/800/600?random={$i}")->toArray();

        foreach (range(1, 10) as $index) {
            DB::table('promotion_contents')->insert([
                'title' => $faker->sentence(3),
                'image' => $faker->randomElement($onlineImages),
                'content' => $faker->paragraph(5),
                'start_at' => now()->subDays(rand(1, 10)),
                'end_at' => now()->addDays(rand(5, 15)),
                'tag_ids' => implode(',', $faker->randomElements(range(1, 10), rand(2, 5))),
                'views' => $faker->numberBetween(0, 1000),
                'category_id' => $faker->numberBetween(1, 5),
                'status' => $faker->randomElement(['active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
