<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
/** @test */
function it_tracks_product_stock()
{

    Notification::fake();
    $this->seed(RetailerWithProductSeeder::class);

    $product = Product::first();
    $this->assertFalse($product->inStock());

    $this->mockClientRequest($available = true);

    $this->artisan('track')
        ->expectsOutput('All done!');

    $this->assertTrue($product->refresh()->inStock());
}

    /** @test */
    function it_does_not_notify_when_the_stock_remains_unavailable()
    {
        Notification::fake();
        $this->seed(RetailerWithProductSeeder::class);
        $this->mockClientRequest($available = false);
        $this->artisan('track');
        Notification::assertNothingSent();
    }


/** @test */
function it_notifies_the_user_when_the_stock_is_now_available()
{
    Notification::fake();
    $this->seed(RetailerWithProductSeeder::class);
    $this->mockClientRequest($available = true);
    $this->artisan('track');
    Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
}



}
