<?php

namespace App\Models;


use App\Events\NowInStock;
use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];


    public function track($callback = null)
    {
          (new TrackStock($this))->handle();
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }





}
