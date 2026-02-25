<?php

namespace App\Http\Livewire\Pages\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $surname = '';
    public string $address = '';
    public string $phone = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $seller = false;

    // Mercadillos disponibles
    public array $markets = [
        "Mercadillos de Mazo",
        "Mercadillo del Paso",
        "Mercadillo de Puntagorda",
        "Mercadillo de Santa Cruz"
    ];
    public array $selected_markets = [];

    /**
     * Manejar el registro de usuario
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Mapear correctamente el teléfono
        $validated['phone_number'] = $validated['phone'] ?? null;
        unset($validated['phone']);

        // Hashear contraseña
        $validated['password'] = Hash::make($validated['password']);

        // Crear usuario
        $user = User::create($validated);

        // Asignar rol según checkbox
        if ($this->seller) {
            $user->assignRole('seller');
        } else {
            $user->assignRole('customer');
        }

        // Evento de registro para email verification
        event(new Registered($user));

        // Login automático
        Auth::login($user);

        // Redirigir
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="fixed inset-0 bg-cover bg-center bg-no-repeat flex items-center justify-center md:grid md:grid-cols-2 md:bg-white" 
     style="background-image: url('{{ asset('img/background.jpg') }}')">
   
    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden p-10 m-4 
              md:bg-white md:shadow-none md:rounded-none md:m-0 md:max-w-full md:h-full md:flex md:items-center md:justify-center md:backdrop-blur-none">
        
        <div class="w-full md:max-w-md 2xl:max-w-2xl">
            <h2 class="font-titulo-principal text-2xl font-bold text-center text-gray-800 mb-8 md:text-left md:text-3xl 2xl:text-4xl">
                Registro
            </h2>

            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form wire:submit.prevent="register">
                <div class="mb-5">
                    <x-input-label for="name" value="Nombre"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="name" id="name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="text" name="name" required placeholder="Introduce tu nombre"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="surname" value="Apellidos"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="surname" id="surname" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="text" name="surname" required placeholder="Introduce tus apellidos"/>
                    <x-input-error :messages="$errors->get('surname')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="address" value="Dirección"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="address" id="address" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="text" name="address" placeholder="Introduce tu dirección (Opcional)"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="phone" value="Número de teléfono"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="phone" id="phone" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="text" name="phone" placeholder="Introduce tu número de teléfono (Opcional)"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="email" value="Correo Electrónico"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="email" id="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="email" name="email" required placeholder="Introduce tu correo electrónico"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="password" value="Contraseña"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="password" id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="password" name="password" required placeholder="Introduce tu contraseña"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="password_confirmation" value="Confirmar contraseña"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors" 
                        type="password" name="password_confirmation" required placeholder="Confirma tu contraseña"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="mb-6 font-semibold">
                    <label for="seller" class="flex items-center">
                        <input wire:model="seller" type="checkbox" 
                            class="w-4 h-4 text-primary rounded focus:ring-primary"/>
                        <span class="ml-2 text-sm text-gray-600">Registrarse como vendedor</span>
                    </label>
                </div>

                @if($seller)
                    <div class="mb-6">
                        <label for="markets" class="block text-gray-700 text-sm font-medium mb-2">Selecciona los mercadillos</label>
                        <select id="markets" wire:model="selected_markets" multiple 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors bg-transparent">
                            @foreach($markets as $market)
                                <option value="{{ $market }}">{{ $market }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <x-primary-button class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex justify-center">
                    Registrarse
                </x-primary-button>

                <div class="mt-6 text-center text-sm text-gray-600">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" wire:navigate.hover class="text-primary hover:text-primary-hover font-medium hover:underline">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>

    <div class="hidden md:block h-full w-full bg-cover bg-center" style="background-image: url('{{ asset('img/background.jpg') }}')"></div>
</div>