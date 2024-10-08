<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = \Modules\Product\Models\Product::class;
    public function definition(): array
    {

        return [
            'name'=>$this->faker->sentence,
            'price_in_cents'=>random_int(100,10000),
            'stock'=>random_int(0,10),
        ];
    }
}
