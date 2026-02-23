<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;

class RootController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:root']);
    }

    /**
     * Dashboard principal del root
     * GET /root
     */
    public function index()
    {
        return view('root.dashboard');
    }

    /**
     * Listado de usuarios del sistema
     * GET /root/users
     */
    public function users()
    {
        $users = User::with('roles')->latest()->get();

        return view('root.users.index', compact('users'));
    }

    /**
     * Mostrar formulario de edición de roles
     * GET /root/users/{user}/roles
     */
    public function editRoles(User $user)
    {
        $roles = Role::all();

        return view('root.users.roles', compact('user', 'roles'));
    }

    /**
     * Actualizar roles de un usuario
     * POST /root/users/{user}/roles
     */
    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array|required',
            'roles.*' => 'exists:roles,name'
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('root.users')
            ->with('success', 'Roles actualizados correctamente');
    }

    /**
     * Eliminar usuario del sistema
     * DELETE /root/users/{user}
     */
    public function destroyUser(User $user)
    {
        // Evitar que root se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente');
    }
}