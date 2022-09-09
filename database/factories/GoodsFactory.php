<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GoodsFactory extends Factory
{
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "color" => $this->faker->colorName(),
            "price" => $this->faker->numberBetween(1000,100000),
            "qty" => $this->faker->numberBetween(0,100),
        ];
    }
}
