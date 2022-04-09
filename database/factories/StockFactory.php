<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stock;
use App\Models\Product;

class StockFactory extends Factory
{

    // protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'type'       => $this->faker->numberBetween(1,2),
            'quantity'   => $this->faker->randomNumber
        ];
    }
}
