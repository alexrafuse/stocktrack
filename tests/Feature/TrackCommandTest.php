<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        $this->seed(RetailerWithProductSeeder::class);
    }

    /** @test */
    function it_tracks_product_stock()
    {
        $product = Product::first();
        $this->assertFalse($product->inStock());
        $this->mockClientRequest($available = true);
        $this->artisan('track')
            ->expectsOutput('All done!');
        $this->assertTrue($product->refresh()->inStock());
    }



}
