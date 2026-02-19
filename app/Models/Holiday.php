<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holiday extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $timestamps = false;
    protected $fillable = [
        'flea_market_id',
        'start_date',
        'end_date',
    ];

    /**
     * Obtener el mercadillo al que pertenece este día festivo.
     */
    public function fleaMarket(): BelongsTo {
        return $this->belongsTo(FleaMarket::class);
    }
}
