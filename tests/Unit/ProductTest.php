<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function it_checks_stock_products_at_retailers()
    {

        $switch = Product::create(['name' => 'Nintendo Switch']);
        $bestBuy = Retailer::create(['name' => 'Best Buy']);
        $this->assertFalse($switch->inStock());
        $bestBuy->addStock($switch, new Stock([
            'price' => 10000,
            'url' => 'http://alexrafuse.com/thing',
            'sku' => '12345',
            'in_stock' => true,
        ]));
        $this->assertTrue($switch->inStock());
    }
}
