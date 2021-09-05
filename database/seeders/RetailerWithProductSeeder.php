<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use function tap;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create(['name' => 'Fake Product']);
        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $bestBuy->addStock($product, new Stock([
            'price' => 99999,
            'url' => 'https://foo.com',
            'sku' => '12345',
            'in_stock' => false,
        ]));

        User::factory()->create(['email'=> 'hey@alexrafuse.com']);
    }
}
