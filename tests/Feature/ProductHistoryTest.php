<?php

namespace Tests\Feature;

use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_a_stock_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        \Http::fake(function() {
            return [
                'salePrice' => 10000, 'onlineAvailability' => true
            ];
        });

        $this->assertSame(0, History::count());



        $product = tap(Product::first())->track();


        $this->assertSame(1, History::count());

        $history = History::first();

        $stock = $product->stock[0];

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);

    }

}
