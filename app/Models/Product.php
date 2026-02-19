<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'unit',
    ];

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);

    }

    public function category(): BelongsTo
    {

        return $this->belongsTo(Category::class);

    }

    public function photos(): HasMany
    {

        return $this->hasMany(Photo::class);

    }
    public function orders(): BelongsToMany
    {

        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price_per_unit','status');

    }
    public function stock():BelongsToMany
    {
        return $this->belongsToMany(Stall::class)->withPivot('quantity', 'price_per_unit');
    }

}
