<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FleaMarket extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'address',
        'municipality_id',
        'img_url'
    ];

    /**
     * Obtener los horarios asociados a este mercadillo.
     */
    public function schedules(): HasMany {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Obtener los días festivos asociados a este mercadillo.
    */
    public function holidays(): HasMany {
        return $this->hasMany(Holiday::class);
    }

    /**
     * Obtener el municipio al que pertenece este mercadillo.
     */
    public function municipality(): BelongsTo {
        return $this->belongsTo(Municipality::class);
    }
}
