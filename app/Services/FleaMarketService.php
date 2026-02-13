<?php

namespace App\Services;

use App\Models\FleaMarket;
use Illuminate\Support\Facades\Auth;

class FleaMarketService
{
    /**
     *Listado de mercadillos
     */
    public function getAllBasic()
    {
        return FleaMarket::with([
            'municipality',
            'schedules',
            'holidays'
        ]) ->where('user_id', Auth::id())
        ->get();
    }
    /**
     * Detalle completo de un mercadillo
     */
    public function getFullById(int $id)
    {
        return FleaMarket::with([
            'municipality',
            'schedules',
            'holidays',
            'stalls.user',
            'stalls.products'
        ])->findOrFail($id);
    }
}
