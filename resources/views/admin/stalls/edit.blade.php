@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Editar Puesto</h1>

        <a href="{{ route('admin.control-panel', ['id' => $stall->flea_market_id, 'tab' => 'stalls']) }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-6">
            ← Volver
        </a>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.stalls.update', $stall->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ $stall->name }}" class="w-full p-2 border rounded" />
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="information" class="block text-gray-700 font-bold mb-2">Información</label>
                    <textarea id="information" name="information" class="w-full p-2 border rounded" rows="4">{{ $stall->information }}</textarea>
                    @error('information')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 font-bold mb-2">Usuario asignado</label>
                    <select id="user_id" name="user_id" class="w-full p-2 border rounded">
                        <option value="">Sin asignar</option>
                        @foreach($assignableUsers as $user)
                            <option value="{{ $user->id }}" {{ (string) old('user_id', $stall->user_id) === (string) $user->id ? 'selected' : '' }}>
                                {{ trim($user->name . ' ' . ($user->surname ?? '')) }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 flex items-center gap-4">
                  
                    <input type="hidden" name="active" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="active" value="1" {{ $stall->active ? 'checked' : '' }} />
                        <span class="text-gray-700">Activo</span>
                    </label>

                    <input type="hidden" name="home_delivery" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="home_delivery" value="1" {{ $stall->home_delivery ? 'checked' : '' }} />
                        <span class="text-gray-700">Domicilio</span>
                    </label>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar cambios
                    </button>
                    <a href="{{ route('admin.control-panel', ['id' => $stall->flea_market_id, 'tab' => 'stalls']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
