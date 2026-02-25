<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>
<div class="fixed inset-0 bg-cover bg-center bg-no-repeat flex items-center justify-center md:grid md:grid-cols-2 md:bg-white"
    style="background-image: url('{{ asset('img/background.jpg') }}')">

    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden p-10 m-4 
              md:bg-white md:shadow-none md:rounded-none md:m-0 md:max-w-full md:h-full md:flex md:items-center md:justify-center md:backdrop-blur-none">

        <div class="w-full md:max-w-md 2xl:max-w-2xl">
            <h2 class="font-titulo-principal text-2xl font-bold text-center text-gray-800 mb-8 md:text-left md:text-3xl 2xl:text-4xl">
                ¡Bienvenido!
            </h2>

            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form wire:submit.prevent="login">
                <div class="mb-5">
                    <x-input-label for="email" value="Correo Electrónico"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="form.email" id="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
                        type="email" name="email" required autofocus autocomplete="username"
                        placeholder="Introduce tu correo electrónico."/>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-input-label for="password" value="Contraseña"
                        class="block text-gray-700 text-sm font-medium mb-2"/>
                    <x-text-input wire:model="form.password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="Introduce tu contraseña."/>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label for="remember" class="flex items-center">
                        <input wire:model="form.remember" id="remember" name="remember" type="checkbox"
                            class="w-4 h-4 text-primary rounded focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate.hover
                            class="text-primary hover:text-primary-hover hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <x-primary-button class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex justify-center">
                    {{ __('Iniciar sesión') }}
                </x-primary-button>

                <div class="mt-6 text-center text-sm text-gray-600">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" wire:navigate.hover class="text-primary hover:text-primary-hover font-medium hover:underline">
                        Regístrate
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="hidden md:block h-full w-full bg-cover bg-center" style="background-image: url('{{ asset('img/background.jpg') }}')"></div>
</div>