<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'sale_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'offer_quantity' => $this->faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
} 