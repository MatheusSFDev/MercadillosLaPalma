<x-app-layout>
    <div class="min-h-screen bg-[#eef2e6] py-8 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                // 🛠️ MODO PRUEBA: Cambia esto a 'vendedor' o 'comprador' para ver los distintos diseños
                $rolPrueba = 'vendedor'; 

                // Cuando el backend esté listo y tengas usuarios reales, borrarás la línea de arriba 
                // y descomentarás la línea de abajo:
                // $rolPrueba = auth()->check() ? auth()->user()->role : 'invitado';
            @endphp

            @if($rolPrueba === 'vendedor')
                <livewire:seller.order-management />
            
            @elseif($rolPrueba === 'comprador')
                <div class="p-10 bg-white rounded-lg shadow text-center">
                    <h2 class="text-2xl font-bold">Vista del Comprador (En construcción) 🚧</h2>
                </div>
            
            @else
                <div class="p-10 bg-red-100 text-red-700 rounded-lg text-center font-bold">
                    No tienes permiso para ver esta página. Inicia sesión.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>