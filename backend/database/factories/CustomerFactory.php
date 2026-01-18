<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('de_DE');

        return [
            'name' => $faker->lastName(),
            'first_name' => $faker->firstName(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => $faker->phoneNumber(),
            'street' => $faker->streetAddress(),
            'postal_code' => $faker->postcode(),
            'city' => $faker->city(),
        ];
    }
}
