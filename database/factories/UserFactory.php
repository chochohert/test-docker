<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'external_id' => Str::uuid(),
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make("testPassword")
        ];
    }
}
