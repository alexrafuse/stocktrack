<?php

namespace App\Models;

use App\Clients\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Facades\App\Clients\ClientFactory;

class Retailer extends Model
{
    use HasFactory;

    public function addStock(Product $product, Stock $stock)
    {
        $stock->product_id = $product->id;
        $this->stock()->save($stock);

    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function client(): Client
    {
        return ClientFactory::make($this);
    }
}
