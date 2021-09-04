<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
/** @test */
function it_tracks_product_stock()
{
    //GIVEN
    //  I have a product with stock
    $switch = Product::create(['name' => 'Nintendo Switch']);
    $bestBuy = Retailer::create(['name' => 'Best Buy']);
    $this->assertFalse($switch->inStock());
    $stock = new Stock([
        'price' => 10000,
        'url' => 'http://alexrafuse.com/thing',
        'sku' => '12345',
        'in_stock' => false,
    ]);
    $bestBuy->addStock($switch, $stock);

    $this->assertFalse($stock->fresh()->in_stock);

    //WHEN
    // I trigger php artisan track and assuming the sock is availalbe now

    Http::fake(function() {
        return [
            'available' => true,
            'price' => 29900
        ];
    });

    $this->artisan('track');

    //THEN
    // Stock details should be refreshed
    $this->assertTrue($stock->fresh()->in_stock);
}

}
