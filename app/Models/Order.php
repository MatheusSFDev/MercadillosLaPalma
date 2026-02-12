<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\User;
use App\Models\Stall;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'home_delivery',
        'information',
        'active',
        'reset_date',
    ];

    // Falta test relaciones
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)->withPivot('quantity','price_per_unit','status');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function stall(): BelongsTo {
        return $this->belongsTo(Stall::class);
    }
}
