<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stall extends Model
{
    //
    protected $fillable = [
        "flea_market_id",
        "user_id",
        "home_delivery",
        "information",
        'active',
        'reset_date',
        'register_date',
        'name',
        'img_url',
    ];

    public function fleaMarket(): BelongsTo{
        return $this->belongsTo(FleaMarket::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }

    public function paymentMethods(): BelongsToMany{
        return $this->belongsToMany(PaymentMethod::class,'payment_method_stall');
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price_per_unit');
    }
}
