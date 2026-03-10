<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\FleaMarketService;

class MarketManager extends Component
{
    public $selectedFleaMarketId = null;
    public $tab = 'stalls';
    public $editingStallId = null;
    public $editName, $editInformation, $editActive, $editHomeDelivery;

    protected $fleaMarketService;

    public function mount(FleaMarketService $fleaMarketService, $selectedFleaMarketId = null, $tab = 'stalls')
    {
        $this->fleaMarketService = $fleaMarketService;
        $this->selectedFleaMarketId = $selectedFleaMarketId;
        $this->tab = $tab;
    }

    public function selectFleaMarket($fleaMarketId)
    {
        $this->selectedFleaMarketId = $fleaMarketId;
        $this->tab = 'stalls';
        $this->editingStallId = null;
    }

    public function selectTab($tab)
    {
        $this->tab = $tab;
        
        if ($tab !== 'stalls') {
            $this->editingStallId = null;
        }
    }

    public function backToFleaMarkets()
    {
        $this->selectedFleaMarketId = null;
    }

    public function editStall($stallId)
    {
        $stall = \App\Models\Stall::find($stallId);
        $this->editingStallId = $stallId;
        $this->editName = $stall->name;
        $this->editInformation = $stall->information;
        $this->editActive = $stall->active;
        $this->editHomeDelivery = $stall->home_delivery;
    }

    public function cancelEdit()
    {
        $this->editingStallId = null;
        $this->reset(['editName', 'editInformation', 'editActive', 'editHomeDelivery']);
    }

    public function render()
    {
        if ($this->selectedFleaMarketId) {
            // Mostrar mercadillos incluido horarios cuando sea necesario
            $query = auth()->user()->fleaMarketsAsAdmin()
                ->with(['stalls.user', 'stalls.orders', 'stalls.products', 'municipality', 'schedules']);


            $fleaMarket = $query->findOrFail($this->selectedFleaMarketId);

            return view('livewire.admin.market-manager', compact('fleaMarket'));
        } else {
            // Mostrar mercadillos asignados al admin
            $fleaMarkets = auth()->user()->fleaMarketsAsAdmin()
                ->with(['municipality', 'stalls'])
                ->get();

            return view('livewire.admin.market-manager', compact('fleaMarkets'));
        }
    }
}
