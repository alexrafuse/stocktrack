<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get('https://alexrafuse.com/api/stocktrack/bestBuy')->json();

        return new StockStatus(
            $results['available'],
            $results['price'],
        );
    }
}
