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
        "home_delivery",
        "information",
    ];

    public function fleaMarket(): BelongsTo{
        return $this->belongsTo(FleaMarket::class, 'flea_market_id', 'flea_market_id');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id', 'user_id');
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class,'stalls_id','stalls_id');
    }

    public function paymentMethods(): BelongsToMany{
        return $this->belongsToMany(PaymentMethod::class,'payment_method_stall');
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class,'stalls_category');
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class,'stock_products')->withPivot('quantity', 'price_per_unit');
    }
}
