<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'Giảm giá sản phẩm', 'status' => 'active'],
            ['title' => 'Ưu đãi mùa hè', 'status' => 'inactive'],
            ['title' => 'Chương trình khách hàng thân thiết', 'status' => 'active'],
            ['title' => 'Khuyến mãi sinh nhật', 'status' => 'active'],
            ['title' => 'Flash Sale', 'status' => 'inactive'],
        ];

        foreach ($categories as $category) {
            DB::table('promotion_categories')->insert([
                'title' => $category['title'],
                'status' => $category['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
