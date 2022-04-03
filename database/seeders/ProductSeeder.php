<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("products")->insert([
            [
                "shop_id"               => 1,
                "secondary_category_id" => 1,
                "image01"               => 1,
            ],
            [
                "shop_id"               => 1,
                "secondary_category_id" => 1,
                "image01"               => 2,
            ],
            [
                "shop_id"               => 1,
                "secondary_category_id" => 2,
                "image01"               => 3,
            ],
            [
                "shop_id"               => 1,
                "secondary_category_id" => 2,
                "image01"               => 4,
            ],
            [
                "shop_id"               => 1,
                "secondary_category_id" => 3,
                "image01"               => 5,
            ],
            [
                "shop_id"               => 1,
                "secondary_category_id" => 3,
                "image01"               => 6,
            ],
        ]);
    }
}
