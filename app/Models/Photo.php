<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = [
        'product_id',
        'url',
        'description'
    ];

    public function product(): BelongsTo
    {

        return $this->belongsTo(Product::class);
    }
}
