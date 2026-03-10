<h1>Productos</h1>
<ul>
    @forelse ($products as $product)
        <li>{{ $product }}</li>
    @empty
        <li>Sin productos</li>
    @endforelse
</ul>