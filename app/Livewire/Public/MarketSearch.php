<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\FleaMarket;

class MarketSearch extends Component
{
    public function render()
    {
        $markets = FleaMarket::with([
            'municipality',
            'schedules'
        ])
        ->withCount('stalls')
        ->get();

        return view('livewire.public.market-search', compact('markets'));
    }
}