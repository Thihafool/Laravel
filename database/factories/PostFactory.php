<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $address = ['Yangon', 'Mandalay', 'Bago', 'NewYork', 'Japan', 'Singapore'];

        return [
            'title' => $this->faker->sentence(8),
            'description' => $this->faker->text(800),
            'price' => rand(3000, 50000),
            'address' => $address[array_rand($address)],
            'rating' => rand(0, 5)
        ];
    }
}
