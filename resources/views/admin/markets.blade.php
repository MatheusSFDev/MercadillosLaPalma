@extends('layouts.app')

@section('content')
<div class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-sans">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>

    <div class="flex flex-1">
        <aside class="w-64 bg-sidebar-light dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 flex flex-col pt-8 px-6">
            <nav class="space-y-4">
                <a href="{{ route('admin.markets') }}" class="block px-6 py-2.5 {{ $tab === 'index' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide">
                    Indice
                </a>
                <a href="{{ route('admin.markets', ['tab' => 'requests']) }}" class="block px-6 py-2.5 {{ $tab === 'requests' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide">
                    Solicitudes
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-12">
            <header class="mb-10">
                @if(session('success'))
                    <div class="mb-4 rounded border border-green-400 bg-green-50 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded border border-red-400 bg-red-50 p-4 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($tab === 'requests')
                    <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Solicitudes Generales</h1>
                    <p class="text-text-gold dark:text-amber-500 text-lg">Solicitudes de puestos de todos tus mercadillos</p>
                @else
                    <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Mercadillos</h1>
                    <p class="text-text-gold dark:text-amber-500 text-lg">Mercadillos que puedes gestionar</p>
                @endif
            </header>

            <div class="max-w-4xl space-y-6">
                @if($tab === 'requests')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg p-8 shadow-sm">
                        <h3 class="text-2xl font-bold mb-3 serif-font dark:text-white">Solicitudes Generales</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Solicitudes de puestos de todos tus mercadillos.</p>

                        @if($pendingStalls->isEmpty())
                            <div class="rounded border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900 p-6 text-gray-600 dark:text-gray-300">
                                No hay solicitudes pendientes.
                            </div>
                        @else
                            <form action="{{ route('admin.stalls.accept') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <div class="space-y-2">
                                    @foreach($pendingStalls as $stall)
                                        <div class="flex items-start justify-between gap-3 rounded border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                                            <label class="flex items-start gap-3 flex-1">
                                                <input type="checkbox" name="stall_ids[]" value="{{ $stall->id }}" class="mt-1 h-4 w-4 rounded text-primary focus:ring-primary" />
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $stall->name ?? 'Puesto #' . $stall->id }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">({{ $stall->fleaMarket->municipality->name }})</span>
                                                        @if($stall->user)
                                                            <span class="text-xs text-gray-500 dark:text-gray-400"> - {{ $stall->user->name }}</span>
                                                        @endif
                                                    </div>
                                                    @if($stall->information)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $stall->information }}</p>
                                                    @endif
                                                </div>
                                            </label>
                                            <button type="submit" form="delete-stall-{{ $stall->id }}" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" onclick="return confirm('¿Eliminar solicitud de puesto?')">Eliminar</button>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded hover:opacity-90">
                                        Aceptar seleccionados
                                    </button>
                                    <a href="{{ route('admin.markets') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:opacity-90">
                                        Cancelar
                                    </a>
                                </div>
                            </form>

                            @foreach($pendingStalls as $stall)
                                <form id="delete-stall-{{ $stall->id }}" action="{{ route('admin.stalls.destroy', $stall) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        @endif
                    </div>
                @else
                    @foreach($fleaMarkets as $fleaMarket)
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden flex items-center p-4 gap-6">
                            <div class="w-48 h-32 flex-shrink-0">
                                @if($fleaMarket->img_url)
                                    <img alt="{{ $fleaMarket->municipality->name }} Market" class="w-full h-full object-cover rounded-lg" src="{{ asset($fleaMarket->img_url) }}" />
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-gray-400">storefront</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 flex justify-between items-center pr-4">
                                <div>
                                    <h3 class="text-2xl font-display text-gray-800 dark:text-gray-100 mb-3">{{ $fleaMarket->municipality->name }}</h3>
                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-primary">Puestos</span>
                                        <span class="text-sm">{{ $fleaMarket->stalls->count() }} puestos</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $fleaMarket->address }}</p>
                                </div>
                                <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'stalls']) }}" class="bg-primary hover:opacity-90 transition-opacity text-white px-6 py-2 rounded-md font-display tracking-tight">
                                    Gestionar Puestos
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
