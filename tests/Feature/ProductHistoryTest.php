<?php

namespace Tests\Feature;

use App\Clients\StockStatus;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_a_stock_is_tracked()
    {

        $this->seed(RetailerWithProductSeeder::class);
        $this->mockClientRequest($available = false, $price = 9999);
        $product = Product::first();
        $this->assertCount(0, $product->history);
        $product->track();
        $this->assertCount(1, $product->refresh()->history);
        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }

}
