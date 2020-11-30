<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trade_name' => "{$this->faker->unique()->name} trade",
            'scientist_name' => "{$this->faker->unique()->name} scientist",
            'amount' => $this->faker->numberBetween(50, 100),
            'weight' => $this->faker->numberBetween(0, 99999),
            'status' => 'Available',
        ];
    }
}
