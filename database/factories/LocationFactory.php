<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->word(),
            'address'           => $this->faker->streetAddress(),
            'address_secondary' => $this->faker->secondaryAddress(),
            'city'              => $this->faker->city(),
            'state'             => $this->faker->state(),
            'country'           => $this->faker->country(),
            'zipcode'           => $this->faker->postcode(),
            'latitude'          => $this->faker->latitude(),
            'longitude'         => $this->faker->longitude(),
        ];
    }
}
