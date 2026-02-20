<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Obtener los mercadillos asociados a este municipio.
     */
    public function fleaMarkets(): HasMany {
        return $this->hasMany(FleaMarket::class);
    }
}
