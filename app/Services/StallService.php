<?php
namespace App\Services;

use App\Models\Stall;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StallService
{
    /**
     * Obtener puestos con usuario y productos
     */
    public function getAllWithRelations(int $perPage = 10): LengthAwarePaginator
    {
        return Stall::with([
                'user:id,name,phone,email',
                'products:id,stall_id,name,unit_measure'
            ])
            ->select('id', 'user_id', 'information', 'active', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * dar alta
     */
    public function activate(Stall $stall): void
    {
        $stall->update(['register_date' => now()]);
    }

    /**
     * Dar baja
     */
    public function deactivate(Stall $stall): void
    {
        $stall->update(['register_date' => null ]);
    }
}
