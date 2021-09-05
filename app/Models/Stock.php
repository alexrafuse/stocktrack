<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];


    public function track()
    {
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price,
        ]);

        $this->recordHistory();

    }


    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    protected function recordHistory(): void
    {
        $this->history()->create([
            'price' => $this->price,
            'in_stock' => $this->in_stock,
            'product_id' => $this->product_id,
        ]);
    }

}
