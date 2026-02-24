<div class="group relative h-full bg-white rounded-2xl shadow-sm border border-secondary-cream overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
    <div class="relative h-48 bg-secondary-light">
        <img src="{{ $imagen }}" alt="{{ $nombre }}" class="w-full h-full object-cover">
        
        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-sm">
            <span class="text-primary font-bold">{{ number_format($precio, 2) }}€</span>
        </div>
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <h3 class="text-xl font-serif font-bold text-coffee mb-2">
            {{ $nombre }}
        </h3>
        
        <p class="text-gray-600 text-sm font-sans line-clamp-2 mb-4 flex-grow">
            {{ $descripcion }}
        </p>

        <div class="mt-auto">
            @hasrole('seller|admin|root')
                {{-- Vista para vendedores o administradores --}}
                <a href="#">
                    <button class="w-full bg-coffee/10 hover:bg-coffee text-coffee hover:text-white font-bold py-2 px-4 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Editar
                    </button>
                </a>
            @elsehasrole('customer')
                {{-- Vista para clientes registrados --}}
                <a href="#">
                    <button class="w-full bg-secondary-cream/40 hover:bg-primary hover:text-white text-coffee-dark font-bold py-2 px-4 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Añadir
                    </button>
                </a>
            @else
                {{-- Vista para usuarios no registrados (guests) o genéricos --}}
                <button class="w-full bg-gray-100 text-gray-400 font-bold py-2 px-4 rounded-xl cursor-default flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Añadir
                </button>
            @endhasrole
        </div>
    </div>

    {{-- Overlay de Registro/Login (Aparece en Hover) --}}
    @if(!auth()->check() || (!auth()->user()->hasRole('customer') && !auth()->user()->hasRole('seller') && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('root')))
        <div class="absolute inset-0 bg-white/90 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-6 z-10 text-center">
            @guest
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-coffee mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h4 class="font-serif font-bold text-coffee text-lg mb-2">¿Quieres comprar?</h4>
                <p class="text-xs font-sans text-gray-600 mb-4 px-2">Descubre productos locales iniciando sesión.</p>
                <a href="{{ route('login') }}" class="w-full bg-primary text-white font-bold py-2.5 px-4 rounded-xl shadow-sm hover:bg-primary/90 transition-colors mb-2 text-sm">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="w-full bg-white border-2 border-primary text-primary font-bold py-2 px-4 rounded-xl shadow-sm hover:bg-primary hover:text-white transition-colors text-sm">
                    Crear Cuenta
                </a>
            @endguest
            
            @auth
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-coffee mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h4 class="font-serif font-bold text-coffee text-lg mb-2">Comprador</h4>
                <p class="text-xs font-sans text-gray-600 mb-4 px-2">Completa tu cuenta como cliente para poder realizar pedidos.</p>
                <a href="#" class="w-full bg-coffee text-white font-bold py-2.5 px-4 rounded-xl shadow-sm hover:bg-coffee/90 transition-colors text-sm">
                    Completar Perfil
                </a>
            @endauth
        </div>
    @endif
</div>