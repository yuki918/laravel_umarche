<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// 追記
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("owners")->insert([
            // database\migrations\2022_02_10_071512_create_owners_table.phpを参照する
            // オーナーは複数人存在する仕様なので、複数階層の連想配列になる
            [
                "name" => "test01",
                "email" => "test01@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test02",
                "email" => "test02@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test03",
                "email" => "test03@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test04",
                "email" => "test04@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test05",
                "email" => "test05@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test06",
                "email" => "test06@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test07",
                "email" => "test07@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test08",
                "email" => "test08@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "test09",
                "email" => "test09@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
        ]);
    }
}
