<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="fixed inset-0 bg-cover bg-center bg-no-repeat flex items-center justify-center md:grid md:grid-cols-2 md:bg-white"
    style="background-image: url('{{ asset('img/background.jpg') }}')">

    <div
        class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden p-10 m-4 
                md:bg-white md:shadow-none md:rounded-none md:m-0 md:max-w-full md:h-full md:flex md:items-center md:justify-center md:backdrop-blur-none">

        <div class="w-full md:max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8 md:text-left md:text-3xl">¡Bienvenido!</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="register">
                <div>
                    <x-input-label for="name" value="Nombre" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                        autofocus autocomplete="name" placeholder="Introduce tu nombre" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" value="Correo Electrónico"
                        class="block text-gray-700 text-sm font-medium mb-2" type="email" name="email" required
                        autofocus autocomplete="username" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                        required autocomplete="username" placeholder="Introduce tu correo electrónico." />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" value="Contraseña"
                        class="block text-gray-700 text-sm font-medium mb-2" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password"
                        name="password" required autocomplete="new-password" placeholder="Introduce tu contraseña." />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4 mb-6">
                    <x-input-label for="password_confirmation" value="Confirmar contraseña"
                        class="block text-gray-700 text-sm font-medium mb-2" />

                    <x-text-input wire:model="password_confirmation" id="password_confirmation"
                        class="block mt-1 w-full" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Confirma tu contraseña" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <x-primary-button
                    class="w-full bg-[#2b5c01] hover:bg-[#5a8713] text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex justify-center">
                    {{ __('Registrarse') }}
                </x-primary-button>

                <div class="mt-6 text-center text-sm text-gray-600">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" wire:navigate
                        class="text-[#2b5c01] hover:text-[#5a8713] font-medium hover:underline">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>

    <div class="hidden md:block h-full w-full bg-cover bg-center"
        style="background-image: url('{{ asset('img/background.jpg') }}')">
    </div>

</div>