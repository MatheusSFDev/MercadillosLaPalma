<?php

namespace App\Services;

use App\Models\Stall;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class GenericService
{
    function requestCreateStalls($arrFleaMarketsId)
{
    foreach ($arrFleaMarketsId as $fleaMarketId) {
        Stall::firstOrCreate([
            'user_id' => FacadesAuth::id(),
            'flea_market_id' => $fleaMarketId,
        ], [
            'home_delivery' => false,
            'active' => false,
            'register_date' => now(),
            'img_url' => 'img/imgNotAvailable.png',
        ]);
    }
}
}