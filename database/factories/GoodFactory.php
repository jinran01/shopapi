<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->text(20),
            'category_id' => $this->faker->randomElement(Category::where('level',3)->pluck('id')),
            'description' => $this->faker->text(40),
            'price' => $this->faker->numberBetween(1,9999),
            'stock' => $this->faker->numberBetween(1,999),
            'cover' => 'https://placeimg.com/640/480/any',
            'pics' => [
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
            ],
            'detail' => $this->faker->paragraphs(4,true),
            'is_on' => $this->faker->randomElement([0,1]),
            'is_recommend' => $this->faker->randomElement([0,1]),
        ];
    }
}
