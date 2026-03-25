@extends('layouts.app')

@section('content')
    @hasrole('seller')
        <div>
            <!-- Lleva a \resources\views\livewire\seller\add-product-form.blade.php -->
            <livewire:seller.add-product-form />
        </div>
    @else
        <div class="p-8 text-center">
            <h2 class="text-2xl font-bold text-red-600">Acceso denegado</h2>
            <p class="mt-4">Solo los vendedores registrados pueden ver esta página.</p>
        </div>
    @endhasrole
@endsection