<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.split')] class extends Component {
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

<div class="min-h-screen flex flex-col md:flex-row bg-white">
    <!-- Left Side: Login Form (50%) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-16 lg:px-24 py-12">
        <div class="w-full max-w-md mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="font-playfair text-3xl md:text-4xl text-[#38250f] font-bold mb-2">
                    ¡Bienvenido de vuelta!
                </h1>
                <p class="font-atkinson text-gray-500 text-lg">
                    Introduce tus credenciales
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-dm-serif text-[#38250f] text-lg mb-2">
                        {{ __('Email') }}
                    </label>
                    <input wire:model="form.email" id="email" type="email" name="email" required autofocus
                        autocomplete="username"
                        class="block w-full rounded-lg border-[#7c995c] shadow-sm focus:border-[#5a8713] focus:ring-[#5a8713] font-atkinson" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-dm-serif text-[#38250f] text-lg mb-2">
                        {{ __('Password') }}
                    </label>
                    <input wire:model="form.password" id="password" type="password" name="password" required
                        autocomplete="current-password"
                        class="block w-full rounded-lg border-[#7c995c] shadow-sm focus:border-[#5a8713] focus:ring-[#5a8713] font-atkinson" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="rounded border-gray-300 text-[#2b5c01] shadow-sm focus:ring-[#5a8713]"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600 font-atkinson">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a class="text-sm text-[#38250f] hover:text-[#5a8713] font-atkinson underline decoration-gray-300 hover:decoration-[#5a8713] transition duration-200"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-[#2b5c01] hover:bg-[#5a8713] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a8713] font-atkinson transition duration-200">
                        {{ __('Log in') }}
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    @if (Route::has('register'))
                    <p class="text-sm text-gray-600 font-atkinson">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" wire:navigate
                            class="font-bold text-[#2b5c01] hover:text-[#5a8713] transition duration-200">
                            Regístrate
                        </a>
                    </p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Right Side: Image (50%) - Hidden on Mobile -->
    <div class="hidden md:block md:w-1/2 relative">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('images/login-bg.png') }}"
            alt="Mercadillo Background">
        <!-- Optional Overlay for better contrast/style -->
        <div class="absolute inset-0 bg-black/10"></div>
    </div>
</div>