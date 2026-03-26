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
                <a href="{{ route('admin.markets') }}" class="block px-6 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg text-center font-display tracking-wide">Indice</a>
                <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'requests']) }}" class="block px-6 py-2.5 {{ $tab === 'requests' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide">Solicitudes</a>
                <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'info']) }}" class="block px-6 py-2.5 {{ $tab === 'info' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide">Editar Informacion</a>
                <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'stalls']) }}" class="block px-6 py-2.5 {{ $tab === 'stalls' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide">Puestos</a>
            </nav>
        </aside>

        <main class="flex-1 p-12">
            <header class="mb-10">
                @if(session('success'))
                    <div class="mb-4 rounded border border-green-400 bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded border border-red-400 bg-red-50 p-4 text-red-700">{{ session('error') }}</div>
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

                @if($tab === 'info')
                    <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Editar Mercadillo de {{ $fleaMarket->municipality->name }}</h1>
                    <p class="text-text-gold dark:text-amber-500 text-lg">Modifica la informacion y horarios</p>
                @elseif($tab === 'requests')
                    <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Solicitudes de {{ $fleaMarket->municipality->name }}</h1>
                    <p class="text-text-gold dark:text-amber-500 text-lg">Puestos pendientes de alta</p>
                @else
                    <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Puestos de {{ $fleaMarket->municipality->name }}</h1>
                    <p class="text-text-gold dark:text-amber-500 text-lg">Puestos que puedes gestionar</p>
                @endif
            </header>

            <div class="max-w-4xl space-y-6">
                <div class="mb-6">
                    <a href="{{ route('admin.markets') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">Volver a Mercadillos</a>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $fleaMarket->municipality->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $fleaMarket->address }}</p>
                </div>

                @if($tab === 'info')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg p-8 shadow-sm">
                        <h3 class="text-2xl font-bold mb-3 serif-font dark:text-white">{{ $fleaMarket->municipality->name }}</h3>
                        <form action="{{ route('admin.markets.update', $fleaMarket) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')
                            <section>
                                <h4 class="text-lg font-bold mb-2 serif-font dark:text-white">Direccion</h4>
                                <input type="text" name="address" value="{{ old('address', $fleaMarket->address) }}" class="w-full p-2 border rounded" />
                            </section>
                            <section>
                                <h4 class="text-lg font-bold mb-2 serif-font dark:text-white">Imagen (URL)</h4>
                                <input type="text" name="img_url" value="{{ old('img_url', $fleaMarket->img_url) }}" class="w-full p-2 border rounded" />
                            </section>
                            <section>
                                <h4 class="text-lg font-bold mb-2 serif-font dark:text-white">Horarios</h4>
                                @php
                                    $days = ['lunes','martes','miércoles','jueves','viernes','sábado','domingo'];
                                    $normalizeDay = function ($value) {
                                        $value = mb_strtolower(trim($value), 'UTF-8');
                                        return str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $value);
                                    };
                                    $formatTime = function ($value) {
                                        if (empty($value)) {
                                            return '';
                                        }

                                        return substr((string) $value, 0, 5);
                                    };
                                    $schedulesByDay = $fleaMarket->schedules->mapWithKeys(function($s){
                                        $normalized = mb_strtolower(trim($s->day_of_week), 'UTF-8');
                                        $normalized = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $normalized);
                                        return [$normalized => $s];
                                    });
                                @endphp
                                <div class="space-y-2 max-w-sm">
                                    @foreach($days as $day)
                                        @php
                                            $normalizedDay = $normalizeDay($day);
                                            $sched = $schedulesByDay[$normalizedDay] ?? null;
                                        @endphp
                                        <div class="grid grid-cols-3 items-center gap-2">
                                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ ucfirst($day) }}</span>
                                            <input type="time" name="schedules[{{ $day }}][opening_time]" value="{{ old('schedules.'.$day.'.opening_time', $formatTime($sched->opening_time ?? null)) }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm" />
                                            <input type="time" name="schedules[{{ $day }}][closing_time]" value="{{ old('schedules.'.$day.'.closing_time', $formatTime($sched->closing_time ?? null)) }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm" />
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                            <div class="flex justify-end gap-4 mt-12">
                                <button type="submit" class="bg-primary text-white px-10 py-2.5 rounded serif-font font-bold hover:opacity-90 transition-opacity">Guardar</button>
                                <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'stalls']) }}" class="bg-accent-peach dark:bg-accent-peach/20 text-accent-red px-10 py-2.5 rounded serif-font font-bold hover:opacity-90 transition-opacity">Cancelar</a>
                            </div>
                        </form>
                    </div>
                @elseif($tab === 'requests')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg p-8 shadow-sm">
                        <h3 class="text-2xl font-bold mb-3 serif-font dark:text-white">Solicitudes de puestos</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Puestos que aun no han sido dados de alta.</p>

                        @if($pendingStalls->isEmpty())
                            <div class="rounded border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900 p-6 text-gray-600 dark:text-gray-300">No hay solicitudes pendientes.</div>
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
                                                        @if($stall->user)
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $stall->user->name }})</span>
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
                                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded hover:opacity-90">Aceptar seleccionados</button>
                                    <a href="{{ route('admin.control-panel', ['id' => $fleaMarket->id, 'tab' => 'stalls']) }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:opacity-90">Cancelar</a>
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
                    <div class="mb-6 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold mb-4">Nuevo puesto</h3>
                        <form action="{{ route('admin.stalls.store', $fleaMarket->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="text" name="name" placeholder="Nombre" class="w-full p-2 border rounded" />
                            <textarea name="information" placeholder="Informacion" class="w-full p-2 border rounded"></textarea>
                            <select name="user_id" class="w-full p-2 border rounded">
                                <option value="">Sin asignar</option>
                                @foreach($assignableUsers as $user)
                                    <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>
                                        {{ trim($user->name . ' ' . ($user->surname ?? '')) }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="active" value="0" />
                                <label class="flex items-center gap-1"><input type="checkbox" name="active" value="1" checked /> Activo</label>
                                <input type="hidden" name="home_delivery" value="0" />
                                <label class="flex items-center gap-1"><input type="checkbox" name="home_delivery" value="1" /> Domicilio</label>
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Crear</button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($fleaMarket->stalls as $stall)
                            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-display text-gray-800 dark:text-gray-100">{{ $stall->name ?: 'Puesto ' . $stall->id }}</h3>
                                    @if(!$stall->register_date)
                                        <span class="text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 px-2 py-0.5 rounded-full">Pendiente</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Activo: {{ $stall->active ? 'Si' : 'No' }}</p>
                                @if($stall->user)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Vendedor: {{ $stall->user->name }}</p>
                                @else
                                    <p class="text-sm text-red-600 dark:text-red-400">Sin asignar</p>
                                @endif
                                @if($stall->information)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $stall->information }}</p>
                                @endif
                                <p class="text-sm text-gray-600 dark:text-gray-400">Productos: {{ $stall->products->count() }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pedidos: {{ $stall->orders->count() }}</p>
                                <div class="mt-2 flex gap-2">
                                    <a href="{{ route('admin.stalls.edit', $stall) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-xs">Editar</a>
                                    <form action="{{ route('admin.stalls.destroy', $stall->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs" onclick="return confirm('¿Eliminar puesto?')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection