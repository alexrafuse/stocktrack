<?php


use App\Jobs\TrackStock;
use App\Models\History;
use App\Models\Stock;
use App\Notifications\ImportantStockUpdate;

use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackStockTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        $this->mockClientRequest(true, 24900);
        $this->seed(RetailerWithProductSeeder::class);
        TrackStock::dispatch(Stock::first());
    }


    /** @test */
    function it_notifies_the_user()
    {
        Notification::assertTimesSent(1, ImportantStockUpdate::class);
    }

    /** @test */
    function it_refreshes_the_local_stock()
    {
        tap(Stock::first(), function($stock){
            $this->assertEquals(24900, $stock->price);
            $this->assertTrue($stock->in_stock);
        });
    }

    /** @test */
    function it_records_to_history()
    {
        $this->assertEquals(1, History::count());
    }


}
