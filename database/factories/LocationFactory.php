<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(1000, 99999),
            'latitude' => $this->faker->numberBetween(1000, 99999),
        ];
    }
}
