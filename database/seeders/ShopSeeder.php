<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                // database\seeders\OwnerSeeder.phpで作ったオーナーのID
                "owner_id"    => 1,
                "name"        => "サンプル店舗名1",
                "information" => "サンプル店舗名1の情報が入ります。サンプル店舗名1の情報が入ります。サンプル店舗名1の情報が入ります。サンプル店舗名1の情報が入ります。サンプル店舗名1の情報が入ります。",
                "filename"    => "",
                "is_selling"  => true,
            ],
            [
                "owner_id"    => 2,
                "name"        => "サンプル店舗名2",
                "information" => "サンプル店舗名2の情報が入ります。サンプル店舗名2の情報が入ります。サンプル店舗名2の情報が入ります。サンプル店舗名2の情報が入ります。",
                "filename"    => "",
                "is_selling"  => true,
            ],
            [
                "owner_id"    => 3,
                "name"        => "サンプル店舗名3",
                "information" => "サンプル店舗名3の情報が入ります。サンプル店舗名3の情報が入ります。サンプル店舗名3の情報が入ります。サンプル店舗名3の情報が入ります。",
                "filename"    => "",
                "is_selling"  => true,
            ],
            [
                "owner_id"    => 4,
                "name"        => "サンプル店舗名4",
                "information" => "サンプル店舗名4の情報が入ります。サンプル店舗名4の情報が入ります。サンプル店舗名4の情報が入ります。サンプル店舗名4の情報が入ります。",
                "filename"    => "",
                "is_selling"  => true,
            ],
        ]);
    }
}
