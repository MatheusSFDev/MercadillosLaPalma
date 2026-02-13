<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Constructor
     * Protege todas las rutas excepto index, login y create
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index',
            'login',
            'create',
            'store'
        ]);
    }

    /**
     * Página principal general
     * GET /general
     */
    public function index()
    {
        return view('general.index');
    }

    /**
     * Login (vista legacy, auth real lo maneja auth.php)
     * GET /general/login
     */
    public function login()
    {
        return redirect()->route('login');
    }

    /**
     * Registro (vista legacy)
     * GET /general/register
     */
    public function create()
    {
        return redirect()->route('register');
    }

    /**
     * Pedidos del usuario autenticado
     * GET /general/orders
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
     * Productos del usuario autenticado (vendedor)
     * GET /general/products
     */
    public function showProducts()
    {
        $products = auth()->user()->products()->latest()->get();

        return view('general.products', compact('products'));
    }

    /**
     * Perfil del usuario
     * GET /general/profile
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
     * Registro de usuario (POST)
     * Mantener por compatibilidad
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

        Auth::login($user);

        return redirect()
            ->route('general.profile')
            ->with('success', 'Usuario registrado correctamente');
    }

    /**
     * Formulario de edición de perfil
     */
    public function edit()
    {
        return view('general.edit-profile', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Actualización del perfil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'surname'      => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'address'      => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()
            ->route('general.profile')
            ->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Eliminación de usuario
     * Se ignora el ID recibido por seguridad
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
