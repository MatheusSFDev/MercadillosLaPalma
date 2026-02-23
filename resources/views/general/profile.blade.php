@extends('layouts.app')

@section('content')
        {{-- CSS para limpieza de inputs y efectos --}}
    <style>
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
        select::-ms-expand { display: none; }
        .form-input-profile { @apply w-full border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-base md:text-sm transition-all bg-white; }
        /* Ajuste para que en móvil los inputs no se vean tan pequeños al hacer focus */
        @media (max-width: 640px) {
            .form-input-profile { font-size: 16px; } 
        }
    </style>

    <div class="bg-[#e9f0d6] min-h-screen py-6 md:py-12 font-general text-status-dark">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                {{-- COLUMNA IZQUIERDA (Arriba en móvil): Perfil Rápido --}}
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 flex flex-col items-center text-center border border-white/50 md:sticky md:top-10">

                        {{-- Avatar --}}
                        <form id="avatarForm" action="{{ route('general.profile.update') }}" method="POST" enctype="multipart/form-data" class="group">
                            @csrf
                            @method('PUT')
                            <div class="relative w-28 h-28 md:w-32 md:h-32 mb-4 md:mb-6 mx-auto">
                                <div id="avatarPreview" 
                                    class="w-28 h-28 md:w-32 md:h-32 rounded-full border-4 flex items-center justify-center text-white text-3xl md:text-4xl font-bold overflow-hidden shadow-inner bg-gray-200 transition-transform group-hover:scale-[1.02]"
                                    style="background-image: url('{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}'); background-size: cover; background-position: center;">
                                    @if(!$user->avatar)
                                        <span class="text-gray-500 opacity-80">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*">
                                <label for="avatarInput" class="absolute bottom-0 right-0 md:bottom-1 md:right-1 bg-primary text-white w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-full cursor-pointer shadow-md hover:bg-primary-hover transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </label>
                            </div>
                        </form>

                        <h2 class="text-xl md:text-2xl font-dm-serif font-bold text-status-dark leading-tight">
                            {{ $user->name }} {{ $user->surname }}
                        </h2>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">{{ $user->email }}</p>

                        <div class="mt-4 md:mt-6 w-full pt-4 md:pt-6 border-t border-gray-100">
                            <span class="inline-block bg-primary-light/20 text-primary px-4 md:px-5 py-1 md:py-1.5 rounded-full text-[10px] md:text-xs font-bold tracking-widest uppercase">
                                {{ ucfirst($user->getRoleNames()->first() ?? 'Usuario') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA (Debajo en móvil): Información --}}
                <div class="md:col-span-2">
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl shadow-sm p-5 md:p-8 border border-white">
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 md:mb-8 gap-4">
                            <h3 class="text-xl md:text-2xl font-bold font-dm-serif text-status-dark">Información personal</h3>
                            <button id="editBtn" class="w-full sm:w-auto bg-primary hover:bg-primary-hover text-white px-6 py-2.5 md:py-2 rounded-xl text-sm transition-all font-medium shadow-sm active:scale-95">
                                Editar perfil
                            </button>
                        </div>

                        <form action="{{ route('general.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-y-3 md:gap-y-4" id="personalInfo">
                                
                                {{-- Nombre y Apellidos --}}
                                <div class="bg-white rounded-xl p-4 border border-transparent grid grid-cols-1 md:grid-cols-3 items-start gap-1 md:gap-4">
                                    <span class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider md:mt-2">Nombre y Apellidos</span>
                                    <div class="md:col-span-2">
                                        <p class="info-text font-medium text-sm md:text-base">{{ $user->name }} {{ $user->surname }}</p>
                                        <div class="hidden flex-col gap-3 edit-fields">
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-input-profile" placeholder="Nombre" />
                                            <input type="text" name="surname" value="{{ $user->surname }}" class="form-input-profile" placeholder="Apellidos" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="bg-white rounded-xl p-4 border border-transparent grid grid-cols-1 md:grid-cols-3 items-center gap-1 md:gap-4">
                                    <span class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Email</span>
                                    <div class="md:col-span-2">
                                        <p class="info-text font-medium text-sm md:text-base">{{ $user->email }}</p>
                                        <input type="email" name="email" value="{{ $user->email }}" class="hidden form-input-profile edit-fields" />
                                    </div>
                                </div>

                                {{-- Teléfono --}}
                                <div class="bg-white rounded-xl p-4 border border-transparent grid grid-cols-1 md:grid-cols-3 items-center gap-1 md:gap-4">
                                    <span class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Teléfono</span>
                                    <div class="md:col-span-2">
                                        <p class="info-text font-medium text-sm md:text-base">{{ $user->phone_number ?? 'No especificado' }}</p>
                                        <input type="text" name="phone_number" value="{{ $user->phone_number ?? '' }}" class="hidden form-input-profile edit-fields" />
                                    </div>
                                </div>

                                {{-- Dirección --}}
                                <div class="bg-white rounded-xl p-4 border border-transparent grid grid-cols-1 md:grid-cols-3 items-center gap-1 md:gap-4">
                                    <span class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Dirección</span>
                                    <div class="md:col-span-2">
                                        <p class="info-text font-medium text-sm md:text-base">{{ $user->address ?? 'No especificada' }}</p>
                                        <input type="text" name="address" value="{{ $user->address ?? '' }}" class="hidden form-input-profile edit-fields" />
                                    </div>
                                </div>

                                {{-- Puestos --}}
                                <div class="bg-white rounded-xl p-4 border border-transparent grid grid-cols-1 md:grid-cols-3 items-center gap-1 md:gap-4">
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Puestos</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="font-medium text-sm md:text-base text-gray-500">
                                            {{ $user->puestos && $user->puestos > 0 ? $user->puestos : '' }}
                                        </p>
                                    </div>
                                </div>

                            </div>

                            {{-- Botón de Guardar --}}
                            <div class="mt-8 hidden flex justify-end" id="saveBtnContainer">
                                <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-10 py-3 md:py-2.5 rounded-xl text-sm font-medium shadow-md transition-all active:scale-95">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    // Avatar logic
    document.getElementById('avatarInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('avatarPreview');
                preview.style.backgroundImage = `url(${e.target.result})`;
                preview.innerHTML = '';
                document.getElementById('avatarForm').submit();
            };
            reader.readAsDataURL(file);
        }
    });

    // Edit logic
    const editBtn = document.getElementById('editBtn');
    editBtn.addEventListener('click', () => {
        const isEditing = editBtn.textContent.trim() === 'Cancelar';
        
        document.querySelectorAll('.info-text').forEach(p => p.classList.toggle('hidden'));
        
        document.querySelectorAll('.edit-fields').forEach(field => {
            field.classList.toggle('hidden');
            if (field.classList.contains('flex-col')) {
                if (!isEditing) field.classList.add('flex');
                else field.classList.remove('flex');
            }
        });

        document.getElementById('saveBtnContainer').classList.toggle('hidden');
        
        editBtn.textContent = isEditing ? 'Editar perfil' : 'Cancelar';
        editBtn.classList.toggle('bg-primary');
        editBtn.classList.toggle('bg-gray-400');
    });
    </script>
@endsection