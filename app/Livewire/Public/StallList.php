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

        $this->stalls = $this->fleaMarket->stalls()->get();

        $this->categories = Category::all()->toArray();

    }

    public function render()
    {
        return view('livewire.public.stall-list-content', [
            'fleaMarket' => $this->fleaMarket,
            'stalls' => $this->stalls,
            'categories' => $this->categories
        ]);
    }
}