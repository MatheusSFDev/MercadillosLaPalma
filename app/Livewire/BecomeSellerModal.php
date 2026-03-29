<?php

namespace App\Livewire;

use App\Models\FleaMarket;
use App\Models\Stall;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;

class BecomeSellerModal extends Component
{
    public User $user;

    public bool $isOpen = false;
    public bool $submitted = false;

    public array $selectedMarkets = [];
    public array $selectedMarketNames = [];

    public $fleaMarkets = [];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->loadAvailableFleaMarkets();
    }

    protected function rules(): array
    {
        return [
            'selectedMarkets' => ['required', 'array', 'min:1'],
            'selectedMarkets.*' => ['integer', 'exists:flea_markets,id'],
        ];
    }

    protected $messages = [
        'selectedMarkets.required' => 'Selecciona al menos un mercadillo para continuar.',
        'selectedMarkets.min' => 'Selecciona al menos un mercadillo para continuar.',
    ];

    protected function loadAvailableFleaMarkets(): void
    {
        $alreadyRegisteredFleaMarketIds = Stall::query()
            ->where('user_id', $this->user->id)
            ->pluck('flea_market_id');

        $this->fleaMarkets = FleaMarket::query()
            ->with('municipality')
            ->whereNotIn('id', $alreadyRegisteredFleaMarketIds)
            ->orderBy('id')
            ->get();
    }

    public function openModal(): void
    {
        $this->resetValidation();
        $this->selectedMarkets = [];
        $this->selectedMarketNames = [];
        $this->submitted = false;

        $this->loadAvailableFleaMarkets();
        $this->isOpen = true;

        $this->dispatch('seller-modal-opened');
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->dispatch('seller-modal-closed');
    }

    public function submit(): void
    {
        $this->validate();

        $availableMarketIds = FleaMarket::query()
            ->whereIn('id', $this->selectedMarkets)
            ->whereNotIn('id', function ($query) {
                $query->select('flea_market_id')
                    ->from('stalls')
                    ->where('user_id', $this->user->id);
            })
            ->pluck('id');

        $selected = FleaMarket::query()
            ->with('municipality')
            ->whereIn('id', $availableMarketIds)
            ->get();

        foreach ($selected as $market) {
            Stall::create([
                'user_id'        => $this->user->id,
                'flea_market_id' => $market->id,
                'home_delivery'  => false,
                'information'    => null,
                'active'         => false,
                'reset_date'     => null,
                'register_date'  => Carbon::now(),
                'name'           => null,
                'img_url'        => 'img/imgNotAvailable.png',
                'status'         => 'pending',
            ]);
        }

        $this->selectedMarketNames = $selected
            ->pluck('name')
            ->values()
            ->toArray();

        $this->submitted = true;

        $this->loadAvailableFleaMarkets();
    }

    public function closeSuccess(): void
    {
        $this->isOpen = false;
        $this->dispatch('seller-modal-closed');
    }

    public function render()
    {
        return view('livewire.become-seller-modal');
    }
}