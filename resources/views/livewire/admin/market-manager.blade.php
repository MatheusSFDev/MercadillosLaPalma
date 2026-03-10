<div>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>Mercadillos en la Palma - Dashboard</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&amp;family=Inter:wght@400;500;600&amp;display=swap"
            rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
            rel="stylesheet" />
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            primary: "#556241",
                            "background-light": "#E2E9D1",
                            "background-dark": "#1a1c18",
                            "sidebar-light": "#FFFFFF",
                            "text-gold": "#937C4B",
                            "footer-dark": "#0A1208",
                        },
                        fontFamily: {
                            display: ["Playfair Display", "serif"],
                            sans: ["Inter", "sans-serif"],
                        },
                        borderRadius: {
                            DEFAULT: "8px",
                        },
                    },
                },
            };
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        </style>
    </head>

    <body class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-sans">
        <div class="flex flex-1">
            <aside
                class="w-64 bg-sidebar-light dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 flex flex-col pt-8 px-6">
                
                <nav class="space-y-4">
                    <a wire:click.prevent="selectTab('index')" class="block px-6 py-2.5 {{ $tab==='index' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide"
                        href="#">
                        Índice
                    </a>
                    @if(isset($fleaMarket))
                        <a wire:click.prevent="selectTab('info')" class="block px-6 py-2.5 {{ $tab==='info' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide"
                            href="#">
                            Editar Información
                        </a>
                        <a wire:click.prevent="selectTab('stalls')" class="block px-6 py-2.5 {{ $tab==='stalls' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide"
                            href="#">
                            Puestos
                        </a>
                        <a wire:click.prevent="selectTab('requests')" class="block px-6 py-2.5 {{ $tab==='requests' ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-lg text-center font-display tracking-wide"
                            href="#">
                            Solicitudes
                        </a>
                    @else
                        <a class="block px-6 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg text-center font-display tracking-wide"
                            href="#">
                            Solicitudes
                        </a>
                    @endif
                </nav>
            </aside>
            <main class="flex-1 p-12">
                <header class="mb-10">
                    @if(isset($fleaMarket))
                        @if($tab === 'info')
                            <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Editar Mercadillo de {{ $fleaMarket->municipality->name }}</h1>
                            <p class="text-text-gold dark:text-amber-500 text-lg">Modifica la información y horarios</p>
                        @else
                            <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Puestos de {{ $fleaMarket->municipality->name }}</h1>
                            <p class="text-text-gold dark:text-amber-500 text-lg">Puestos que puedes gestionar</p>
                        @endif
                    @elseif(isset($fleaMarkets))
                        <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Mercadillos</h1>
                        <p class="text-text-gold dark:text-amber-500 text-lg">Mercadillos que puedes gestionar</p>
                    @endif
                </header>
                <div class="max-w-4xl space-y-6">
                    @if(isset($fleaMarket))
                        
                        <div class="mb-6">
                            <button wire:click="backToFleaMarkets"
                                    class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
                                ← Volver a Mercadillos
                            </button>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Puestos de {{ $fleaMarket->municipality->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ $fleaMarket->address }}</p>
                        </div>

                        @if($tab === 'info')
                            <div class="bg-white dark:bg-zinc-800 rounded-lg p-8 shadow-sm">
                                <h3 class="text-2xl font-bold mb-3 serif-font dark:text-white">{{ $fleaMarket->municipality->name }}</h3>
                                <form action="{{ route('admin.markets.update', $fleaMarket) }}" method="POST" class="space-y-6">
                                    @csrf
                                    @method('PATCH')
                                    <section>
                                        <h4 class="text-lg font-bold mb-2 serif-font dark:text-white">Dirección</h4>
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
                                            $schedulesByDay = $fleaMarket->schedules->mapWithKeys(function($s){
                                                return [strtolower($s->day_of_week) => $s];
                                            });
                                        @endphp
                                        <div class="space-y-2 max-w-sm">
                                            @foreach($days as $day)
                                                @php
                                                    $sched = $schedulesByDay[$day] ?? null;
                                                @endphp
                                                <div class="grid grid-cols-3 items-center gap-2">
                                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ ucfirst($day) }}</span>
                                                    <input type="time" name="schedules[{{ $day }}][opening_time]" value="{{ old('schedules.'.$day.'.opening_time', $sched->opening_time ?? '') }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm" />
                                                    <input type="time" name="schedules[{{ $day }}][closing_time]" value="{{ old('schedules.'.$day.'.closing_time', $sched->closing_time ?? '') }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </section>
                                    <div class="flex justify-end gap-4 mt-12">
                                        <button type="submit" class="bg-primary text-white px-10 py-2.5 rounded serif-font font-bold hover:opacity-90 transition-opacity">
                                            Guardar
                                        </button>
                                        <button type="button" wire:click="selectTab('stalls')" class="bg-accent-peach dark:bg-accent-peach/20 text-accent-red px-10 py-2.5 rounded serif-font font-bold hover:opacity-90 transition-opacity">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                                <h3 class="text-xl font-semibold mb-4">Nuevo puesto</h3>
                                <form action="{{ route('admin.stalls.store', $fleaMarket->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <input type="text" name="name" placeholder="Nombre" class="w-full p-2 border rounded" />
                                    <textarea name="information" placeholder="Información" class="w-full p-2 border rounded"></textarea>
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}" />
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="active" value="0" />
                                        <label class="flex items-center gap-1">
                                            <input type="checkbox" name="active" value="1" checked /> Activo
                                        </label>
                                        <input type="hidden" name="home_delivery" value="0" />
                                        <label class="flex items-center gap-1">
                                            <input type="checkbox" name="home_delivery" value="1" /> Domicilio
                                        </label>
                                    </div>
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                                        Crear
                                    </button>
                                </form>
                            </div>
                        @endif

                     

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($fleaMarket->stalls as $stall)
                                @if($this->editingStallId == $stall->id)
                                    
                                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden p-4">
                                        <h3 class="text-lg font-display text-gray-800 dark:text-gray-100 mb-2">Editar Puesto</h3>
                                        <form action="{{ route('admin.stalls.update', $stall) }}" method="POST" class="space-y-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="name" wire:model="editName" placeholder="Nombre" class="w-full p-2 border rounded" value="{{ $this->editName }}" />
                                            <textarea name="information" wire:model="editInformation" placeholder="Información" class="w-full p-2 border rounded">{{ $this->editInformation }}</textarea>
                                            <input type="hidden" name="user_id" value="{{ $stall->user_id }}" />
                                            <div class="flex items-center gap-4">
                                                <input type="hidden" name="active" value="0" />
                                                <label class="flex items-center gap-1">
                                                    <input type="checkbox" name="active" value="1" wire:model="editActive" {{ $this->editActive ? 'checked' : '' }} /> Activo
                                                </label>
                                                <input type="hidden" name="home_delivery" value="0" />
                                                <label class="flex items-center gap-1">
                                                    <input type="checkbox" name="home_delivery" value="1" wire:model="editHomeDelivery" {{ $this->editHomeDelivery ? 'checked' : '' }} /> Domicilio
                                                </label>
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                                                    Guardar
                                                </button>
                                                <button type="button" wire:click="cancelEdit" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                              
                                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden p-4">
                                        <h3 class="text-lg font-display text-gray-800 dark:text-gray-100 mb-2">{{ $stall->name ?: 'Puesto ' . $stall->id }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Activo: {{ $stall->active ? 'Sí' : 'No' }}</p>
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
                                            <button wire:click="editStall({{ $stall->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-xs">
                                                Editar
                                            </button>
                                            <form action="{{ route('admin.stalls.destroy', $stall->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs" onclick="return confirm('¿Eliminar puesto?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @elseif(isset($fleaMarkets))
                        
                        @foreach($fleaMarkets as $fleaMarket)
                            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden flex items-center p-4 gap-6">
                                <div class="w-48 h-32 flex-shrink-0">
                                    @if($fleaMarket->img_url)
                                        <img alt="{{ $fleaMarket->municipality->name }} Market" class="w-full h-full object-cover rounded-lg"
                                             src="{{ asset($fleaMarket->img_url) }}" />
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
                                            <span class="material-symbols-outlined text-primary">storefront</span>
                                            <span class="text-sm">{{ $fleaMarket->stalls->count() }} puestos</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $fleaMarket->address }}</p>
                                    </div>
                                    <button wire:click="selectFleaMarket({{ $fleaMarket->id }})"
                                            class="bg-primary hover:opacity-90 transition-opacity text-white px-6 py-2 rounded-md font-display tracking-tight">
                                        Gestionar Puestos
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </main>
        </div>
        <footer class="bg-footer-dark text-white py-3 px-12">
            <div class="flex justify-between text-[10px] uppercase tracking-wider">
                <a class="hover:underline" href="#">Política de Protección de datos</a>
                <a class="hover:underline" href="#">Aviso Legal</a>
                <a class="hover:underline" href="#">Política de Cookies</a>
            </div>
        </footer>

    </body>

    </html>
</div>