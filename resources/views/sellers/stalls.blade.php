<h1>PUESTOS</h1>

<ul>
    @forelse($stalls as $stall)
        <li>{{ $stall }}</li>
    @empty
        <li>Sin puestos asignados</li>
    @endforelse
</ul>