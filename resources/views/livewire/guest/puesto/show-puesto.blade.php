<div class="min-h-screen bg-gray-50 w-full">
    <div class="relative h-64 md:h-80 bg-coffee overflow-hidden">
        <img src="{{ $datosPuesto['banner'] }}" class="w-full h-full object-cover opacity-60">
        
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-32 h-32 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg -mb-16 md:mb-0">
                        <img src="{{ $datosPuesto['logo'] }}" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="text-center md:text-left flex-grow">
                        <h1 class="text-3xl md:text-5xl font-serif font-bold text-white mb-2 drop-shadow-md">
                            {{ $datosPuesto['nombre'] }}
                        </h1>
                        <p class="text-secondary-cream font-sans font-bold uppercase tracking-widest text-sm">
                            Vendedor: {{ $datosPuesto['vendedor'] }} | {{ $datosPuesto['poblacion'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 md:pt-12 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-serif font-bold text-coffee mb-6">Productos disponibles</h2>
                
            </div>

        </div>
    </div>
</div>