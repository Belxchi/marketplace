<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    // Define o modelo associado a esta factory
    protected $model = Product::class;

    /**
     * Define o estado padrão dos atributos.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3)
        ];
    }
}
