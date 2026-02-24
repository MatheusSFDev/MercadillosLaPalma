<div
    class="h-full bg-white rounded-2xl shadow-sm border border-secondary-cream overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col">
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

        <button
            class="w-full bg-secondary-cream/40 hover:bg-primary hover:text-white text-coffee-dark font-bold py-2 px-4 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Añadir
        </button>
    </div>
</div>