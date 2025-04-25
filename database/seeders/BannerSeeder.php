<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $onlineImages = collect(range(11, 20))->map(fn($i) => "https://picsum.photos/800/300?random={$i}")->toArray();

        foreach (range(1, 5) as $index) {
            DB::table('banners')->insert([
                'title' => 'Banner ' . $index,
                'image' => $faker->randomElement($onlineImages), // ✅ Chọn ảnh ngẫu nhiên
                'link' => $faker->boolean(70) ? $faker->url : null,
                'status' => $faker->randomElement(['active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
