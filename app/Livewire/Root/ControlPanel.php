<?php

namespace App\Livewire\Root;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ControlPanel extends Component
{
    // Propiedades para filtrado
    public $search = '';
    public $roleFilter = '';
    
    // Mantenemos los roles seleccionados en un array vinculado
    public $selectedRoles = [];

    // Solo cargamos los roles disponibles una vez al iniciar
    public function mount()
    {
        // Pre-cargamos los roles de todos los usuarios para los checkboxes
        foreach (User::with('roles')->get() as $user) {
            $this->selectedRoles[$user->id] = $user->roles->pluck('name')->toArray();
        }
    }

    /**
     * Limpiar la paginación o estados cuando se busca (opcional si usas pagination)
     */
    public function updatedSearch()
    {
        // Acciones adicionales al buscar
    }

    public function updateRoles($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'No puedes cambiar tus propios roles');
            return;
        }

        $rolesToSync = $this->selectedRoles[$userId] ?? [];

        // --- SEGURIDAD ROOT ---
        // 1. Si el usuario NO es root, quitamos 'root' de la lista por si se inyectó vía HTML
        if (!$user->hasRole('root')) {
            $rolesToSync = array_diff($rolesToSync, ['root']);
        } 
        // 2. Si el usuario YA es root, nos aseguramos de que 'root' permanezca en el array
        else {
            if (!in_array('root', $rolesToSync)) {
                $rolesToSync[] = 'root';
            }
        }

        $user->syncRoles($rolesToSync);
        
        // Actualizamos el estado local de los checkboxes
        $this->selectedRoles[$user->id] = $user->roles->pluck('name')->toArray();

        session()->flash('success', "Permisos de {$user->name} actualizados.");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($userId === auth()->id() || $user->hasRole('root')) {
            session()->flash('error', 'No se puede eliminar a este usuario (es Root o eres tú).');
            return;
        }

        $user->delete();

        session()->flash('success', 'Usuario eliminado correctamente');
    }

    public function render()
    {
        // Realizamos la consulta con filtros directamente en el render
        $usersCollection = User::with('roles')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('surname', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function($query) {
                $query->role($this->roleFilter);
            })
            ->get();

        // Ordenar para que Root esté siempre primero
        $sortedUsers = $usersCollection->sortByDesc(fn($u) => $u->hasRole('root'));

        return view('livewire.root.control-panel', [
            'users' => $sortedUsers,
            'roles' => Role::all(),
        ]);
    }
}