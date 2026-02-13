<article class="group relative flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-secondary-cream overflow-hidden">
    
    <div class="relative h-56 overflow-hidden bg-secondary-light">
        <img src="{{ $imagen }}" 
             alt="{{ $titulo }}" 
             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
        
        <div class="absolute top-3 left-3">
            <span class="inline-block px-3 py-1 text-xs font-bold tracking-wider text-white uppercase bg-primary/90 rounded-full backdrop-blur-sm shadow-sm">
                {{ $categoria }}
            </span>
        </div>
    </div>

    <div class="flex flex-col flex-grow p-6">
        
        <div class="flex items-center gap-2 mb-2 text-coffee-light text-xs font-sans uppercase tracking-wide">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ $ubicacion }}
        </div>

        <h3 class="text-2xl font-serif font-bold text-coffee mb-3 group-hover:text-primary transition-colors leading-tight">
            {{ $titulo }}
        </h3>

        <p class="text-gray-600 font-sans text-sm leading-relaxed line-clamp-3 mb-6 flex-grow">
            {{ $descripcion }}
        </p>

        <div class="pt-4 border-t border-secondary-cream/50 mt-auto">
            <button class="w-full group/btn relative flex items-center justify-center gap-2 px-4 py-3 bg-secondary-cream/20 text-coffee-dark font-bold rounded-lg overflow-hidden transition-all duration-300 hover:bg-primary hover:text-white hover:shadow-md">
                <span class="relative z-10">Visitar Puesto</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 relative z-10 transform group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </div>
</article>