<?php

namespace Tests\Feature;

use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use function var_dump;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
/** @test */
function it_tracks_product_stock()
{

    $this->seed(RetailerWithProductSeeder::class);
    $this->assertFalse(Product::first()->inStock());

    \Http::fake(function() {
        return [
            'salePrice' => 299.99, 'onlineAvailability' => true
        ];
    });

    $this->artisan('track')
        ->expectsOutput('All done!');
    $this->assertTrue(Product::first()->inStock());
}

}
