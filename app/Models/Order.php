<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\User;
use App\Models\Stall;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'stall_id',
        'order_date',
        'delivery_date',
        'completed'
    ];

    // Relaciones
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)->withPivot('quantity','price_per_unit','status');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function stall(): BelongsTo {
        return $this->belongsTo(Stall::class);
    }

    //Scopes
    #[Scope]
    public function status(Builder $query, $status) {
        return $query->where('status', $status);
    }

    #[Scope]
    public function month(Builder $query, $month) {
        return $query->whereMonth('order_date', $month);
    }

    #[Scope]
    public function year(Builder $query, $year) {
        return $query->whereYear('order_date', $year);
    }

    #[Scope]
    public function productsCount(Builder $query) {
        return $query->withCount('products');
    }

    #[Scope]
    public function totalPrice(Builder $query)
    {
        return $query->addSelect([
            'total_price' => DB::table('order_product')
                ->selectRaw('SUM(quantity * price_per_unit)')
                ->whereColumn('order_product.order_id', 'orders.id')
        ]);
    }
}    
