<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'flea_market_id',
        'day_of_week',
        'opening_time',
        'closing_time',
    ];

    /**
     * Obtener el mercadillo al que pertenece este horario.
     */
    public function fleaMarket(): BelongsTo {
        return $this->belongsTo(FleaMarket::class);
    }
}
