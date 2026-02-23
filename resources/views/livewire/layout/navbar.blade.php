<?php
// Obtenemos el usuario de forma segura
$user = auth()->user();
?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <img class="block h-16 w-auto" src="{{ asset('img/logo-mercadillos.png') }}" alt="Mercadillos La Palma" />
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

                <!-- <a href="{{ route('home') }}"
                    class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    Mercadillos
                </a> -->

                @auth
                    {{-- Opciones de VENDEDOR --}}
                    @if ($user->role === 'vendedor')
                        <a href="{{ route('seller.index-stalls') }}" {{-- CORREGIDO --}}
                            class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Mis Puestos
                        </a>
                        <a href="{{ route('general.orders') }}" {{-- CORREGIDO --}}
                            class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Mis Pedidos
                        </a>
                        <a href="{{ route('seller.edit-products') }}" {{-- CORREGIDO --}}
                            class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Mis Productos
                        </a>

                        @if (request()->routeIs('seller.edit-products'))
                            {{-- CORREGIDO --}}
                            <a href="{{ route('seller.create-product') }}" {{-- CORREGIDO --}}
                                class="bg-green-100 text-green-800 px-3 py-2 rounded-md text-sm font-medium">
                                + Añadir Producto
                            </a>
                        @endif
                    @endif

                    {{-- Opciones de COMPRADOR --}}
                    @if ($user->role === 'comprador')
                        <a href="{{ route('customer.cart') }}" {{-- CORREGIDO --}}
                            class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            🛒 Mi Carrito
                        </a>
                        <a href="{{ route('general.orders') }}" {{-- CORREGIDO --}}
                            class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Mis Pedidos
                        </a>

                        {{-- Asegúrate de que esta ruta seller.request exista en web.php --}}
                        <a href="{{ route('seller.request') }}"
                            class="ml-4 bg-orange-100 text-orange-700 hover:bg-orange-200 px-3 py-2 rounded-md text-sm font-medium border border-orange-300">
                            🏪 ¡Quiero Vender!
                        </a>
                    @endif

                    {{-- Opciones de ADMIN --}}
                    @if ($user->role === 'admin')
                        <a href="{{ route('admin.control-panel') }}" {{-- CORREGIDO --}}
                            class="text-red-500 hover:text-red-700 font-bold px-3 py-2 text-sm">
                            Panel Admin
                        </a>
                    @endif
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                        <div>
                            <button @click="dropdownOpen = !dropdownOpen" type="button"
                                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Abrir menú</span>
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                    alt="{{ $user->name }}">
                            </button>
                        </div>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="px-4 py-2 text-xs text-gray-400">
                                {{ $user->name }} ({{ ucfirst($user->role) }})
                            </div>

                            {{-- CORREGIDO: Ruta perfil --}}
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 font-medium">Iniciar
                            sesión</a>
                        <a href="{{ route('register') }}"
                            class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-hover">Registrarse</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-gray-50">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/"
                class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                Mercadillos
            </a>

            @auth
                @if ($user->role === 'vendedor')
                    <div class="border-t border-gray-200 my-2"></div>
                    <span class="px-4 text-xs text-gray-400 font-bold uppercase">Zona Vendedor</span>
                    {{-- CORREGIDO RUTAS MÓVIL --}}
                    <a href="{{ route('seller.index-stalls') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mis
                        Puestos</a>
                    <a href="{{ route('general.orders') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mis
                        Pedidos</a>
                    <a href="{{ route('seller.edit-products') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mis
                        Productos</a>
                @endif

                @if ($user->role === 'comprador')
                    <a href="{{ route('customer.cart') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mi
                        Carrito</a>
                    <a href="{{ route('general.orders') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mis
                        Pedidos</a>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4 flex items-center">
                    <div class="shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover"
                            src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                            alt="{{ $user->name }}" />
                    </div>
                    <div class="ms-3">
                        <div class="font-medium text-base text-gray-800">{{ $user->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Mi
                        Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left ps-3 pe-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 p-4">
                    <a href="{{ route('login') }}"
                        class="block text-center w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-md mb-2">Iniciar
                        Sesión</a>
                    <a href="{{ route('register') }}"
                        class="block text-center w-full bg-green-600 text-white py-2 rounded-md">Registrarse</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
