<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name'       => 'キッズファッション',
                'sort_order' => 1,
            ],
            [
                'name'       => '出産祝い・ギフト',
                'sort_order' => 2,
            ],
            [
                'name'       => 'ベビーカー',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name'       => '靴',
                'sort_order' => 1,
                'primary_category_id' => 1,
            ],
            [
                'name'       => 'トップス',
                'sort_order' => 2,
                'primary_category_id' => 1,
            ],
            [
                'name'       => 'ランドセル',
                'sort_order' => 3,
                'primary_category_id' => 2,
            ],
            [
                'name'       => 'ギフトセット',
                'sort_order' => 4,
                'primary_category_id' => 2,
            ],
            [
                'name'       => '記念品',
                'sort_order' => 5,
                'primary_category_id' => 2,
            ],
            [
                'name'       => 'ケーキ',
                'sort_order' => 6,
                'primary_category_id' => 2,
            ],
            [
                'name'       => '装飾品',
                'sort_order' => 7,
                'primary_category_id' => 3,
            ],
            [
                'name'       => '日除け',
                'sort_order' => 8,
                'primary_category_id' => 3,
            ],
            [
                'name'       => 'おもちゃ',
                'sort_order' => 9,
                'primary_category_id' => 3,
            ],
        ]);
    }
}
