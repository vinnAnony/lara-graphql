<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->firstName() . ' ' . ['Resume', 'Cover Letter', 'Tax PIN'][rand(0, 2)],
            'description' => $this->faker->text(100),
            'url' => $this->faker->url(),
            'user_id' => $this->faker->randomNumber(2),
        ];
    }
}
