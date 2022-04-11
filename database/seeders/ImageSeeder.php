<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
          [
              "owner_id" => 1,
              "filename" => "sample01.jpg",
              "title"    => "サンプル画像01",
          ],
          [
              "owner_id" => 1,
              "filename" => "sample02.jpg",
              "title"    => "サンプル画像02",
          ],
          [
              "owner_id" => 1,
              "filename" => "sample03.jpg",
              "title"    => "サンプル画像03",
          ],
          [
              "owner_id" => 1,
              "filename" => "sample04.jpg",
              "title"    => "サンプル画像04",
          ],
          [
              "owner_id" => 1,
              "filename" => "sample05.jpg",
              "title"    => "サンプル画像05",
          ],
          [
              "owner_id" => 1,
              "filename" => "sample06.jpg",
              "title"    => "サンプル画像06",
          ],
        ]);
    }
}
