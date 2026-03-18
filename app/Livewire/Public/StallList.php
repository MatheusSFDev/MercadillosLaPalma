<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\FleaMarket;
use App\Models\Stall;
use App\Models\Category;

class StallList extends Component
{
    public $fleaMarket;
    public $stalls;
    public $categories;

    public function mount($fleaMarketId)
    {
        $this->fleaMarket = FleaMarket::with('municipality')
            ->findOrFail($fleaMarketId);

        $this->categories = Category::all()->toArray();
    
        $this->stalls = Stall::where('flea_market_id', $fleaMarketId)->get();

    }

    public function render()
    {
        return view('livewire.public.stall-list-content', [
            'fleaMarket' => $this->fleaMarket,
            'stalls' => $this->stalls,
        ]);
    }
}