<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('information');
            $table->unsignedInteger('price');
            $table->boolean('is_selling');
            $table->integer('sort_order')->nullable();
            // productsには3つの外部キー制約（FK）を設ける
            // shopが削除された場合は、productも削除される
            $table->foreignId('shop_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // 2階層目のカテゴリーと商品画像との外部キー制約
            $table->foreignId('secondary_category_id')->constrained();
            $table->foreignId('image01')->nullable()->constrained('images');
            $table->foreignId('image02')->nullable()->constrained('images');
            $table->foreignId('image03')->nullable()->constrained('images');
            $table->foreignId('image04')->nullable()->constrained('images');
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
        Schema::dropIfExists('products');
    }
}
