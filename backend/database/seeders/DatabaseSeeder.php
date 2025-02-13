<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Offer;
use App\Models\Sale;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::factory(10)->create();

        $offers = Offer::factory(5)
            ->hasAttached(
                $products->random(2),
                ['product_quantity' => rand(1, 5)]
            )
            ->create();

        foreach ($offers as $offer) {
            Sale::factory(1)
                ->create([
                    'offer_id' => $offer->id,
                    'offer_quantity' => rand(1, 10)
                ]);
        }
    }
}
