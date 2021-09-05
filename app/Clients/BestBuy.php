<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;
use function config;
use function var_dump;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {

        $results = Http::get($this->endpoint($stock->sku))->json();

        return new StockStatus(
            $results['onlineAvailability'],
            $this->dollarsToCents($results['salePrice']), // dollars -> cents
        );
    }

    /**
     * @param $sku
     * @param $apiKey
     * @return string
     */
    protected function endpoint($sku): string
    {
        $apiKey = config('services.clients.bestBuy.key');

        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$apiKey}";
    }

    /**
     * @param $salePrice
     * @return int
     */
    protected function dollarsToCents($salePrice): int
    {
        return (int)($salePrice * 100);
    }
}
