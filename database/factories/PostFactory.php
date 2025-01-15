<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 100),
            'title' => $this->faker->name(),
            'description' => $this->faker->unique()->safeEmail(),
            'published_at' => \Carbon\Carbon::now()
        ];
    }


}
