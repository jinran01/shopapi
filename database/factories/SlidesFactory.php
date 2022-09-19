<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SlidesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(),
            'url' =>'',
            'img' => 'https://placeimg.com/1920/400/any',
            'status' => 1,
            'seq' => $this->faker->numberBetween(1,999),
        ];
    }
}
