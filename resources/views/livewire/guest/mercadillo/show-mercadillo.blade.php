<div class="min-h-screen bg-accent-cream/20 pb-20">

    <div class="bg-primary py-12 px-4 sm:px-6 lg:px-8 shadow-md relative overflow-hidden">
        <div class="max-w-[95%] xl:max-w-7xl mx-auto relative z-10">
            <span class="text-accent-yellow uppercase tracking-widest text-sm font-bold mb-2 block">
                Mercadillos de La Palma
            </span>
            <h1 class="text-4xl md:text-5xl font-serif text-white font-bold mb-4">
                {{ $nombreMercadillo }}
            </h1>
            <p class="text-primary-light text-lg max-w-2xl">
                Descubre los mejores productos locales. Apoya el comercio de cercanía y disfruta de la calidad de
                nuestra tierra.
            </p>
        </div>
    </div>

    <div class="max-w-[95%] xl:max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">

        <div class="flex flex-wrap gap-4 mb-8">
            <button
                class="px-6 py-2 rounded-full bg-primary text-white text-sm font-bold shadow-md hover:bg-primary-hover transition-colors">Todos</button>
            <button
                class="px-6 py-2 rounded-full bg-white text-coffee hover:bg-secondary-light hover:text-primary transition-colors text-sm font-bold border border-primary-light/30 shadow-sm">Verduras</button>
            <button
                class="px-6 py-2 rounded-full bg-white text-coffee hover:bg-secondary-light hover:text-primary transition-colors text-sm font-bold border border-primary-light/30 shadow-sm">Artesanía</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach($puestos as $puesto)
            <livewire:components.puesto-card :key="$puesto['id']" :nombre="$puesto['nombre']"
                :categoria="$puesto['categoria']" :imagen="$puesto['imagen']" />
            @endforeach

        </div>
    </div>
</div>