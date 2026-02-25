<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\User;

class GenericController extends Controller
{
    /**
     * Constructor
     * Protege rutas privadas excepto index y store (registro)
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index',
            'store'
        ]);
    }

    /**
     * Página principal general
     * GET /
     */
    public function index()
    {
        return view('general.index');
    }

    /**
     * Pedidos del usuario autenticado
     * GET /customer/orders
     */
    public function orders()
    {
        $orders = auth()->user()
            ->orders()
            ->with(['stall'])
            ->latest()
            ->get();

        return view('general.orders', compact('orders'));
    }

    /**
     * Perfil del usuario autenticado
     * GET /customer/profile
     */
    public function profile()
    {
        $user = auth()->user()->load([
            'stalls',
            'products',
            'fleaMarketsAsAdmin'
        ]);

        return view('general.profile', compact('user'));
    }

    /**
     * Mostrar productos de un puesto específico
     * GET /general/stall/{id}
     */
    public function showStallProducts($id)
    {
        $stall = auth()->user()->stalls()->findOrFail($id);
        $products = $stall->products()->latest()->get();

        return view('general.products', compact('stall', 'products'));
    }

    /**
     * Mostrar puestos de un mercadillo
     * GET /general/fleamarket/{id}/stalls
     */
    public function showStalls($id)
    {
        return view('livewire.public.stall-list', [
            'fleaMarketId' => $id
        ]);
    }

    /**
     * Registro de usuario (POST)
     * Mantener compatibilidad
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'surname'      => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
            'address'      => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'         => $validated['name'],
            'surname'      => $validated['surname'],
            'email'        => $validated['email'],
            'password'     => bcrypt($validated['password']),
            'address'      => $validated['address'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
        ]);

        $user->assignRole('customer');

        Auth::login($user);

        return redirect()
            ->route('general.profile')
            ->with('success', 'Usuario registrado correctamente');
    }

    /**
     * Editar perfil del usuario
     */
    public function edit()
    {
        return view('general.edit-profile', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Actualizar perfil del usuario
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'puestos' => 'nullable|string|max:255',
        ]);

        // Actualizar datos personales
        $user->update($validated);

        // Guardar avatar si hay archivo
        if ($request->hasFile('avatar')) {
            // Guardar en storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        return redirect()
            ->route('general.profile')
            ->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Eliminar cuenta del usuario autenticado
     */
    public function destroy(string $id)
    {
        $user = auth()->user();

        Auth::logout();
        $user->delete();

        return redirect('/')
            ->with('success', 'Cuenta eliminada correctamente');
    }
}
