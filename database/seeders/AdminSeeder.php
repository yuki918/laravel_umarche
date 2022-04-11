<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// 追記
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admins")->insert([
            // database\migrations\2022_02_10_071512_create_admins_table.phpを参照する
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("password1234"),
            "created_at" => "2022/01/01 11:11:11",
        ]);
    }
}
