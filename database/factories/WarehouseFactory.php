<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warehouse>
 */
class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Gudang '.fake()->city(),
            'location' => fake()->city().', '.fake()->country(),
            'capacity' => fake()->numberBetween(100, 10000),
        ];
    }
}
