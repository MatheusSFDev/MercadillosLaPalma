<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\FleaMarketService;

class MarketManager extends Component
{
    public $selectedFleaMarketId = null;
    protected $fleaMarketService;

    public function mount(FleaMarketService $fleaMarketService)
    {
        $this->fleaMarketService = $fleaMarketService;
    }

    public function selectFleaMarket($fleaMarketId)
    {
        $this->selectedFleaMarketId = $fleaMarketId;
    }

    public function backToFleaMarkets()
    {
        $this->selectedFleaMarketId = null;
    }

    public function render()
    {
        if ($this->selectedFleaMarketId) {
            
            $fleaMarket = auth()->user()->fleaMarketsAsAdmin()
                ->with(['stalls', 'municipality'])
                ->findOrFail($this->selectedFleaMarketId);

            return view('livewire.admin.market-manager', compact('fleaMarket'));
        } else {
           
            $fleaMarkets = auth()->user()->fleaMarketsAsAdmin()
                ->with(['municipality', 'stalls'])
                ->get();

            return view('livewire.admin.market-manager', compact('fleaMarkets'));
        }
    }
}
