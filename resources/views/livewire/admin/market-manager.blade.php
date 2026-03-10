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
                    <a class="block px-6 py-2.5 bg-primary text-white rounded-lg text-center font-display tracking-wide"
                        href="#">
                        Índice
                    </a>
                    <a class="block px-6 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg text-center font-display tracking-wide"
                        href="#">
                        Solicitudes
                    </a>
                </nav>
            </aside>
            <main class="flex-1 p-12">
                <header class="mb-10">
                    @if(isset($fleaMarket))
                        <h1 class="text-4xl font-display text-gray-800 dark:text-gray-100 mb-1">Puestos de {{ $fleaMarket->municipality->name }}</h1>
                        <p class="text-text-gold dark:text-amber-500 text-lg">Puestos que puedes gestionar</p>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($fleaMarket->stalls as $stall)
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
                                 
                                </div>
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