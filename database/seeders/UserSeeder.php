<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "name" => "user01",
                "email" => "user01@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "user02",
                "email" => "user02@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "user03",
                "email" => "user03@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "user04",
                "email" => "user04@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
            [
                "name" => "user05",
                "email" => "user05@gmail.com",
                "password" => Hash::make("password1234"),
                "created_at" => "2022/01/01 11:11:11",
            ],
        ]);
    }
}
