<x-app-layout>
    <div class="min-h-screen bg-[#eef2e6] py-8 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                $rol = auth()->check() ? auth()->user()->getRoleNames()->first() : 'invitado';
            @endphp

            @if($rol === 'seller')
                <livewire:seller.order-management />
            @elseif($rol === 'customer')
                <livewire:customers.order-management />
            @else
                <div class="p-10 bg-red-100 text-red-700 rounded-lg text-center font-bold">
                    No tienes permiso para ver esta página. Inicia sesión.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>