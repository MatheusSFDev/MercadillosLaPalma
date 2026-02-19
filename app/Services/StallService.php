<?php
namespace App\Services;

use App\Models\FleaMarket;
use App\Models\Stall;
use App\Models\User;

class StallService
{



    /**
     * Crear un nuevo puesto
     */
    public function create(array $data): Stall
    {
        return Stall::create([
            'flea_market_id' => $data['flea_market_id'],
            'user_id' => $data['user_id'],
            'information' => $data['information'] ?? null,
            'register_date' => $data['register_date'] ?? now(),
            'active' => $data['active'] ?? true,
            'home_delivery' => $data['home_delivery'] ?? false,
            'name' => $data['name'] ?? null,
            'img_url' => $data['img_url'] ?? 'img/imgNotAvailable.png',
        ]);
    }

    /**
     * Actualizar un puesto existente
     */
    public function update(Stall $stall, array $data): Stall
    {
        $stall->update([
            'information' => $data['information'] ?? $stall->information,
            'active' => $data['active'] ?? $stall->active,
            'register_date' => $data['register_date'] ?? $stall->register_date,
            'home_delivery' => $data['home_delivery'] ?? $stall->home_delivery,
            'name' => $data['name'] ?? $stall->name,
            'img_url' => $data['img_url'] ?? $stall->img_url,
        ]);

        return $stall;
    }

    /**
     * Activar un puesto
     */
    public function activate(Stall $stall): void
    {
        $stall->update(['active' => true]);
    }

    /**
     * Desactivar un puesto
     */
    public function deactivate(Stall $stall): void
    {
        $stall->update(['active' => false]);
    }

    /**
     * Eliminar un puesto
     */
    public function delete(Stall $stall): void
    {
        $stall->delete();
    }


    public function getById(int $id): Stall
    {
        return Stall::with([
            'fleaMarket',
            'user',
            'products'
        ])
            ->findOrFail($id);
    }

    /**
     * Puestos de un usuario concreto
     */
    public function getByUser(int $userId)
    {
        return Stall::where('user_id', $userId)
            ->with(['fleaMarket', 'products'])
            ->get();
    }
    public function assignStallToUser(User $user, FleaMarket $mercadillo): Stall
    {
        // Crear el puesto
        $stall = $user->stalls()->create([
            'flea_market_id' => $mercadillo->id,
            'active' => true,
            'register_date' => now(),
            'name' => 'Nuevo puesto',
            'img_url' => 'img/imgNotAvailable.png'
        ]);

        return $stall;
    }
    public function getWithoutRegisterDateByMarket(int $marketId)
    {
        return Stall::where('flea_market_id', $marketId)
            ->whereNull('register_date')
            ->with('user')
            ->get();
    }
    public function registerStall(Stall $stall): Stall
{
    if ($stall->register_date !== null) {
        throw new \Exception('El puesto ya está dado de alta.');
    }

    $stall->update([
        'register_date' => now(),
       
    ]);

    return $stall;
}


}
