@extends('layouts.app')

@section('content')

<div>
<div class="fixed inset-0 z-50 overflow-y-auto bg-white">
    <div class="min-h-full bg-cover bg-center bg-no-repeat flex flex-col justify-center md:grid md:grid-cols-2 md:bg-white" 
         style="background-image: url('{{ asset('img/background.jpg') }}')">
       
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden p-10 mx-auto my-8 
                  md:bg-white md:shadow-none md:rounded-none md:m-0 md:max-w-full md:min-h-screen md:flex md:items-center md:justify-center md:py-12 md:backdrop-blur-none">
            
            <div class="w-full md:max-w-md 2xl:max-w-2xl">
                <h2 class="font-titulo-principal text-2xl font-bold text-center text-gray-800 mb-8 md:text-left md:text-3xl 2xl:text-4xl">
                    Registro
                </h2>

                <x-auth-session-status class="mb-4" :status="session('status')"/>

                <form method="POST" action="{{ route('storedevelop') }}">
    @csrf

    <div class="mb-5">
        <label for="name" class="block text-gray-700 text-sm font-medium mb-2">
            Nombre
        </label>
        <input
            id="name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            placeholder="Introduce tu nombre"
        />
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="surname" class="block text-gray-700 text-sm font-medium mb-2">
            Apellidos
        </label>
        <input
            id="surname"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="text"
            name="surname"
            value="{{ old('surname') }}"
            required
            placeholder="Introduce tus apellidos"
        />
        @error('surname')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="address" class="block text-gray-700 text-sm font-medium mb-2">
            Dirección
        </label>
        <input
            id="address"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="text"
            name="address"
            value="{{ old('address') }}"
            placeholder="Introduce tu dirección (Opcional)"
        />
        @error('address')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">
            Número de teléfono
        </label>
        <input
            id="phone"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="text"
            name="phone"
            value="{{ old('phone') }}"
            placeholder="Introduce tu número de teléfono (Opcional)"
        />
        @error('phone')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
            Correo Electrónico
        </label>
        <input
            id="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            placeholder="Introduce tu correo electrónico"
        />
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
            Contraseña
        </label>
        <input
            id="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="password"
            name="password"
            required
            placeholder="Introduce tu contraseña"
        />
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">
            Confirmar contraseña
        </label>
        <input
            id="password_confirmation"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors"
            type="password"
            name="password_confirmation"
            required
            placeholder="Confirma tu contraseña"
        />
        @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <h2 class="text-gray-700 text-sm font-medium mb-2">
            Para registrarse como vendor seleccione los mercadillos en los que quiera participar
        </h2>

        <label class="block text-gray-700 text-sm font-medium mb-2">
            Selecciona los mercadillos
        </label>

        <div class="space-y-2">
            @foreach($markets as $market)
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        name="selected_markets[]"
                        value="{{ $market->id }}"
                        class="w-4 h-4 text-primary rounded focus:ring-primary border-gray-300"
                        {{ in_array($market->id, old('selected_markets', [])) ? 'checked' : '' }}
                    >
                    <span class="ml-2 text-sm text-gray-700">
                        {{ $market->municipality?->name }}
                    </span>
                </label>
            @endforeach
        </div>

        @error('selected_markets')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @error('selected_markets.*')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex justify-center"
    >
        Registrarse
    </button>

    <div class="mt-6 text-center text-sm text-gray-600">
        ¿Ya tienes una cuenta?
        <a href="{{ route('login') }}" class="text-primary hover:text-primary-hover font-medium hover:underline">
            Inicia sesión
        </a>
    </div>
</form>
            </div>
        </div>

        <div class="hidden md:block h-screen w-full bg-cover bg-center sticky top-0" style="background-image: url('{{ asset('img/background.jpg') }}')"></div>
    </div>
</div>
</div>
@endsection