<!-- resources/views/customers/cart.blade.php -->
<!-- Este es el archivo de vista para el carrito de compras del cliente -->
<!-- ESTO ES UNA PRUEBA -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Carrito de Compras</h1>
    <h2 class="text-lg font-semibold mb-2"> PRUEBA DE DATOS </h2>

    <div class="mb-2">
        <h2 class="text-lg font-semibold mb-2">Añadir Productos</h2>

        <button 
            class="add-to-cart bg-blue-500 text-white px-4 py-2 rounded"
            data-product="1"
            data-stall="1"
            data-qty="1"
        >
            Añadir Producto 1
        </button>

        <button 
            class="add-to-cart bg-blue-500 text-white px-4 py-2 rounded"
            data-product="2"
            data-stall="2"
            data-qty="2"
        >
            Añadir Producto 2
        </button>

        <button 
            class="add-to-cart bg-green-500 text-white px-4 py-2 rounded"
            data-product="4"
            data-stall="4"
            data-qty="1"
        >
            Añadir Producto 3
        </button>

        <button 
            class="add-to-cart bg-green-500 text-white px-4 py-2 rounded"
            data-product="5"
            data-stall="2"
            data-qty="1"
        >
            Añadir Producto 4
        </button>

        <button id="clear-cart" class="bg-red-500 text-white px-4 py-2 rounded">
            Limpiar carrito
        </button>
    </div>

    <div class="mb-4">
        <button id="load-cart" class="bg-purple-500 text-white px-4 py-2 rounded">
            Cargar productos del carrito
        </button>
    </div>

    <div id="cart-products" class="border p-4 rounded">
        <h2 class="text-lg font-semibold mb-2">Productos</h2>
        <p id="loading" style="display:none;">Cargando...</p>
        <div id="products-list"></div>
    </div>
    <div class="my-4">
        <button id="send-cart" class="bg-amber-600 text-white px-4 py-2 rounded">
            Finalizar compra
        </button>
    </div>
</div>

@vite('resources/js/cart.js')
@endsection