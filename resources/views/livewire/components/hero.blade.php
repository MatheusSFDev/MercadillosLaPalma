<div class="relative h-64 md:h-80 bg-coffee overflow-hidden">
    <img src="{{ $imagen }}" class="w-full h-full object-cover opacity-60">
    
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                
                @if($logo)
                <div class="w-32 h-32 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg -mb-16 md:mb-0">
                    <img src="{{ $logo }}" class="w-full h-full object-cover">
                </div>
                @endif
                
                <div class="text-center md:text-left flex-grow">
                    <h1 class="text-3xl md:text-5xl font-serif font-bold text-white mb-2 drop-shadow-md">
                        {{ $titulo }}
                    </h1>
                    @if($subtitulo)
                    <p class="text-secondary-cream font-sans font-bold uppercase tracking-widest text-sm">
                        {{ $subtitulo }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>