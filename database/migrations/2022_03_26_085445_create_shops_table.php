<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 一オーナー一店舗の制約にする為に外部キー制約を使用する
        // https://readouble.com/laravel/8.x/ja/migrations.html（外部キー制約）
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            // オーナーIDを取得して、そのオーナーのみ管理できるようにする
            // $table->foreignId('owner_id')->constrained();
            // オーナーが削除されたら、ショップも削除される
            $table->foreignId('owner_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('name'); // 店舗名
            $table->text('information'); // 店舗の情報
            $table->string('filename'); // 店舗の画像
            $table->boolean('is_selling'); // 販売しているかどうか
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
