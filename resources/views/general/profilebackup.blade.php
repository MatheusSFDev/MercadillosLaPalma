@extends('layouts.app')

@section('content')
    <style>
        /* Limpiamos estilos por defecto de algunos inputs */
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
        select::-ms-expand { display: none; }
        
        /* Inputs en modo edición */
        .form-input-edit { 
            @apply w-full bg-[#fbfcf9] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#dce6ca] outline-none text-gray-700 font-medium; transition: box-shadow 0.15s, border-color 0.15s; 
        }
        
        /* Cajas blancas en modo vista */
        .view-box {
            @apply w-full bg-white p-3 px-4 rounded-xl shadow-sm text-gray-700 font-medium;
        }

        /* Títulos Serif */
        .font-serif-title {
            font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
        }

        /* ===== MODAL VENDEDOR ===== */
        /* backdrop-filter y animaciones SOLO cuando el modal está abierto (.modal-open)
           Aplicarlos siempre crea compositing layers aunque el modal esté hidden */
        #sellerModal.modal-open {
            backdrop-filter: blur(4px);
            animation: fadeInBackdrop 0.2s ease;
        }
        @keyframes fadeInBackdrop {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        #sellerModal.modal-open #sellerModalBox {
            animation: slideUpModal 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes slideUpModal {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        /* Checkbox custom mercadillo */
        .market-checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 0.85rem;
            border-radius: 0.85rem;
            border: 2px solid transparent;
            background: white;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s, transform 0.1s;
            font-weight: 500;
            color: #3d4530;
            font-size: 0.875rem;
        }
        .market-checkbox-label:hover {
            border-color: #b5c99a;
            background: #f7faf2;
            transform: translateY(-1px);
        }
        .market-checkbox-label input[type="checkbox"] {
            accent-color: #5a6b47;
            width: 1.1rem;
            height: 1.1rem;
            flex-shrink: 0;
        }
        .market-checkbox-label.selected {
            border-color: #5a6b47;
            background: #eef5e6;
        }

        /* Pulse en el botón Vendedor — solo al hacer hover para no sobrecargar el navegador */
        #btnBecomeSeller:hover {
            box-shadow: 0 0 0 4px rgba(90,107,71,0.2);
        }

        /* Éxito: check animado */
        @keyframes popIn {
            0%   { transform: scale(0) rotate(-10deg); opacity: 0; }
            70%  { transform: scale(1.15) rotate(3deg); opacity: 1; }
            100% { transform: scale(1) rotate(0deg);  opacity: 1; }
        }
        .success-check {
            animation: popIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>

    {{-- Fondo verde claro de toda la página --}}
    <div class="bg-[#e4ebce] min-h-screen py-3 md:py-5 font-sans text-gray-800">
        <div class="container mx-auto px-3 md:px-4 max-w-6xl">
            
            {{-- Formulario Principal --}}
            <form id="profileForm" action="{{ route('general.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Contenedor Grid con items-stretch para igualar alturas --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-8 items-stretch">

                    {{-- ================= COLUMNA IZQUIERDA ================= --}}
                    <div class="md:col-span-4 lg:col-span-4">
                        <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm p-6 md:p-10 flex flex-col items-center justify-center h-full min-h-[300px] md:min-h-[400px]">
                            
                            {{-- Avatar --}}
                            <div class="relative w-24 h-24 md:w-36 md:h-36 mb-4 md:mb-6 mx-auto group">
                                <div id="avatarPreview" 
                                    class="w-24 h-24 md:w-36 md:h-36 rounded-full border-4 border-white shadow-md flex items-center justify-center text-white text-3xl md:text-4xl font-bold overflow-hidden bg-[#5a6b47] transition-transform group-hover:scale-[1.02]"
                                    style="background-image: url('{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}'); background-size: cover; background-position: center;">
                                    
                                    @if(!$user->avatar)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-16 md:w-16 opacity-90" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*">
                                
                                {{-- Lápiz de edición avatar --}}
                                <label for="avatarInput" class="absolute bottom-1 right-2 bg-[#f4f4f4] text-gray-700 w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-full cursor-pointer shadow border border-gray-200 hover:bg-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </label>
                            </div>

                            {{-- Nombre --}}
                            <h2 class="text-xl md:text-3xl font-serif-title font-bold text-[#3d4530] mt-2 md:mt-2 text-center">
                                <span class="block text-sm md:text-base">{{ $user->name }}</span>
                                <span class="block text-sm md:text-base">{{ $user->surname }}</span>
                            </h2>
                        </div>
                    </div>

                    {{-- ================= COLUMNA DERECHA ================= --}}
                    <div class="md:col-span-8 lg:col-span-8">
                        <div class="bg-[#f2f5eb] rounded-2xl md:rounded-[2rem] shadow-sm p-5 md:p-12 flex flex-col justify-center h-full">
                            
                            {{-- Cabecera: Título y Botón Editar (Solo visible en View Mode) --}}
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8 gap-3 md:gap-4">
                                <h3 class="text-xl md:text-3xl font-serif-title font-bold text-[#3d4530]">Información personal</h3>
                                
                                <button type="button" id="btnEditProfile" class="view-element bg-[#e1ebd2] hover:bg-[#d0ddbe] text-[#4d593c] px-4 md:px-6 py-2 md:py-2.5 rounded-xl text-xs md:text-sm transition-colors font-bold shadow-sm flex items-center justify-center gap-2 active:scale-95 w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Editar
                                </button>
                            </div>

                            {{-- ===== DATOS PERSONALES ===== --}}
                            <div class="flex flex-col gap-3 md:gap-5">
                                
                                {{-- Nombre Completo --}}
                                <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                    <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Nombre Completo</label>
                                    <div class="w-full md:w-2/3">
                                        <div class="view-element view-box">{{ $user->name }} {{ $user->surname }}</div>
                                        <div class="edit-element hidden flex flex-col md:flex-row gap-2 md:gap-3">
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-input-edit w-full md:w-1/2 rounded-xl bg-gray-100 border-none text-sm" placeholder="Nombre" />
                                            <input type="text" name="surname" value="{{ $user->surname }}" class="form-input-edit w-full md:w-1/2 rounded-xl bg-gray-100 border-none text-sm" placeholder="Apellidos" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                    <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Email</label>
                                    <div class="w-full md:w-2/3">
                                        <div class="view-element view-box text-xs md:text-base">{{ $user->email }}</div>
                                        <input type="email" name="email" value="{{ $user->email }}" class="edit-element hidden form-input-edit rounded-xl bg-gray-100 border-none text-sm" />
                                    </div>
                                </div>

                                {{-- Teléfono --}}
                                <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                    <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Teléfono</label>
                                    <div class="w-full md:w-2/3">
                                        <div class="view-element view-box text-xs md:text-base">{{ $user->phone_number ?? 'No especificado' }}</div>
                                        <input type="text" name="phone_number" value="{{ $user->phone_number ?? '' }}" class="edit-element hidden form-input-edit rounded-xl bg-gray-100 border-none text-sm" />
                                    </div>
                                </div>

                                {{-- Dirección --}}
                                <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                    <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Dirección</label>
                                    <div class="w-full md:w-2/3">
                                        <div class="view-element view-box text-xs md:text-base">{{ $user->address ?? 'No especificada' }}</div>
                                        <input type="text" name="address" value="{{ $user->address ?? '' }}" class="edit-element hidden form-input-edit rounded-xl bg-gray-100 border-none text-sm" />
                                    </div>
                                </div>

                                @hasrole('seller')
                                    {{-- ===== PUESTOS (Solo View Mode) ===== --}}
                                    <div class="view-element bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-start gap-3 md:gap-6">
                                        <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Puestos</label>
                                        <div class="w-full md:w-2/3">
                                            @if ($user->stalls->isEmpty())
                                                <p class="text-gray-500 italic text-xs md:text-base">No tienes puestos asignados.</p>
                                            @else
                                                <ul class="space-y-1 md:space-y-2 text-gray-700 text-xs md:text-base font-medium">
                                                    @foreach ($user->stalls as $stall)
                                                        <li class="flex items-start">
                                                            <span class="mr-2 md:mr-3 text-[#5a6b47]">•</span>
                                                            <span>
                                                                {{ $stall->name }} 
                                                                <span class="text-gray-400 text-xs md:text-sm ml-1 font-normal">({{ $stall->fleaMarket->municipality->name ?? 'Sin mercadillo' }})</span>
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                @endhasrole

                                {{-- ===== CONTRASEÑA ACTUAL (Requerida para cualquier cambio) ===== --}}
                                <div class="edit-element hidden bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6 border-l-4 border-orange-400">
                                    <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Contraseña actual *</label>
                                    <div class="w-full md:w-2/3">
                                        <input type="password" name="current_password" id="currentPassword" class="form-input-edit rounded-xl bg-gray-100 border-none text-sm" placeholder="Ingresa tu contraseña para confirmar cambios" />
                                    </div>
                                </div>

                                {{-- ===== CONTRASEÑA NUEVA (Solo Edit Mode) ===== --}}
                                <div class="edit-element hidden mt-3 md:mt-4">
                                    <h3 class="text-lg md:text-3xl font-serif-title font-bold text-[#3d4530] mb-3 md:mb-5">Cambiar Contraseña</h3>
                                    
                                    <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col gap-3 md:gap-5">

                                        <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                            <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Contraseña nueva</label>
                                            <div class="w-full md:w-2/3">
                                                <input type="password" name="password" class="form-input-edit rounded-xl bg-gray-100 border-none text-sm" />
                                            </div>
                                        </div>

                                        <div class="bg-white rounded-xl px-3 md:p-2 py-2 md:py-2 flex flex-col md:flex-row md:items-center gap-3 md:gap-6">
                                            <label class="md:w-1/3 font-bold text-[#3d4530] text-sm md:text-lg whitespace-nowrap">Confirmar Contraseña</label>
                                            <div class="w-full md:w-2/3">
                                                <input type="password" name="password_confirmation" class="form-input-edit rounded-xl bg-gray-100 border-none text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Botones de Acción (Solo Edit Mode) --}}
                            <div class="edit-element hidden flex flex-col md:flex-row justify-center items-center gap-3 md:gap-6 mt-6 md:mt-10">
                                <button type="submit" class="w-full md:w-auto bg-[#dcf0cd] hover:bg-[#cbe3b9] text-[#4d593c] px-6 md:px-10 py-2 md:py-3 rounded-xl font-bold shadow-sm transition-colors active:scale-95 text-sm md:text-base">
                                    Guardar
                                </button>
                                <button type="button" id="btnCancelEdit" class="w-full md:w-auto bg-[#f0dfd5] hover:bg-[#e6d0c4] text-[#8b4f3a] px-6 md:px-10 py-2 md:py-3 rounded-xl font-bold shadow-sm transition-colors active:scale-95 text-sm md:text-base">
                                    Cancelar
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

            {{-- ========================================================== --}}
            {{-- ===== SECCIÓN: CONVERTIRSE EN VENDEDOR ===== --}}
            {{-- Solo se muestra si el usuario NO tiene el rol 'seller'      --}}
            {{-- ========================================================== --}}
            <div class="mt-6 md:mt-8">
                <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm px-6 py-5 md:px-10 md:py-7 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    {{-- Texto descriptivo --}}
                    <div class="flex items-center gap-4">
                        {{-- Icono puesto de mercado --}}
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-[#eef5e6] flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7 text-[#5a6b47]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-serif-title font-bold text-[#3d4530] text-base md:text-xl">¿Quieres vender en los mercadillos?</p>
                            <p class="text-gray-500 text-xs md:text-sm mt-0.5">Solicita convertirte en vendedor y elige los mercadillos donde quieres tener tu puesto.</p>
                        </div>
                    </div>

                    {{-- Botón --}}
                    <button
                        type="button"
                        id="btnBecomeSeller"
                        class="flex-shrink-0 w-full md:w-auto bg-[#5a6b47] hover:bg-[#4a5939] text-white px-6 md:px-8 py-2.5 md:py-3 rounded-xl font-bold text-sm md:text-base transition-colors active:scale-95 flex items-center justify-center gap-2 shadow-md"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Registrarse como vendedor
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================================ --}}
    {{-- ===== MODAL: SELECCIÓN DE MERCADILLOS ===== --}}
    {{-- ================================================================ --}}
    <div
        id="sellerModal"
        class="hidden fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="sellerModalTitle"
    >
        <div id="sellerModalBox" class="bg-white rounded-2xl md:rounded-[2rem] shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 md:p-10 relative">

            {{-- Botón cerrar --}}
            <button
                type="button"
                id="btnCloseSellerModal"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-[#f2f5eb] hover:bg-[#e1ebd2] text-[#5a6b47] transition-colors"
                aria-label="Cerrar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            {{-- ===== ESTADO: FORMULARIO ===== --}}
            <div id="sellerFormState">
                {{-- Encabezado --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-[#eef5e6] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#5a6b47]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 id="sellerModalTitle" class="font-serif-title font-bold text-[#3d4530] text-xl md:text-2xl">Solicitud de vendedor</h2>
                        <p class="text-gray-400 text-xs mt-0.5">Selecciona los mercadillos en los que te gustaría participar</p>
                    </div>
                </div>

                {{-- Lista de mercadillos --}}
                {{--
                    Cuando tengas el backend listo, sustituye $fleaMarkets por datos reales:
                        $fleaMarkets = \App\Models\FleaMarket::with('municipality')
                                          ->where('active', true)
                                          ->get();
                        return view('general.profile', compact('user', 'fleaMarkets'));
                    Y cambia $simulatedMarkets por $fleaMarkets usando $market->id, $market->name, etc.
                --}}
                @php
                    $fleaMarkets = isset($fleaMarkets) ? $fleaMarkets : collect([
                        (object)['id' => 1, 'name' => 'Mercadillo de Las Ramblas',    'municipality' => (object)['name' => 'Santa Cruz de Tenerife']],
                        (object)['id' => 2, 'name' => 'Mercadillo del Agricultor',    'municipality' => (object)['name' => 'La Laguna']],
                        (object)['id' => 3, 'name' => 'Feria de Artesanía del Norte', 'municipality' => (object)['name' => 'Puerto de la Cruz']],
                        (object)['id' => 4, 'name' => 'Mercadillo de La Recova',      'municipality' => (object)['name' => 'Los Realejos']],
                        (object)['id' => 5, 'name' => 'Mercado de Productores',       'municipality' => (object)['name' => 'Icod de los Vinos']],
                        (object)['id' => 6, 'name' => 'Feria de la Tierra',           'municipality' => (object)['name' => 'Güímar']],
                    ]);
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6" id="marketList">
                    @forelse($fleaMarkets as $market)
                        <label class="market-checkbox-label" id="market-label-{{ $market->id }}">
                            <input
                                type="checkbox"
                                name="flea_market_ids[]"
                                value="{{ $market->id }}"
                                class="market-check"
                            >
                            <span class="flex flex-col">
                                <span class="font-semibold text-[#3d4530]">{{ $market->name }}</span>
                                <span class="text-gray-400 text-xs font-normal">{{ $market->municipality->name ?? 'Sin municipio' }}</span>
                            </span>
                        </label>
                    @empty
                        <p class="text-gray-400 text-sm col-span-2 text-center py-4 italic">
                            No hay mercadillos disponibles en este momento.
                        </p>
                    @endforelse
                </div>

                {{-- Nota informativa --}}
                <div class="bg-[#f2f5eb] rounded-xl px-4 py-3 mb-6 flex gap-3 items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#5a6b47] mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-[#4d593c] text-xs leading-relaxed">
                        Puedes seleccionar uno o varios mercadillos. Un administrador revisará tu solicitud y te notificará cuando sea aprobada.
                    </p>
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        type="button"
                        id="btnSubmitSellerRequest"
                        class="flex-1 bg-[#5a6b47] hover:bg-[#4a5939] text-white py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95 flex items-center justify-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Enviar solicitud
                    </button>
                    <button
                        type="button"
                        id="btnCancelSellerModal"
                        class="flex-1 bg-[#f2f5eb] hover:bg-[#e1ebd2] text-[#4d593c] py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95"
                    >
                        Cancelar
                    </button>
                </div>
            </div>

            {{-- ===== ESTADO: ÉXITO ===== --}}
            <div id="sellerSuccessState" class="hidden flex flex-col items-center text-center py-4 md:py-6 gap-4">
                {{-- Check animado --}}
                <div class="success-check w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#eef5e6] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 md:w-10 md:h-10 text-[#5a6b47]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-serif-title font-bold text-[#3d4530] text-xl md:text-2xl mb-2">¡Solicitud enviada!</h3>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed max-w-xs mx-auto">
                        Hemos recibido tu solicitud para convertirte en vendedor. Un administrador la revisará en breve y te notificará el resultado.
                    </p>
                </div>

                {{-- Mercadillos seleccionados --}}
                <div id="successMarketList" class="w-full bg-[#f2f5eb] rounded-xl px-4 py-3 text-left">
                    <p class="text-xs font-bold text-[#5a6b47] uppercase tracking-wide mb-2">Mercadillos solicitados</p>
                    <ul id="successMarketItems" class="space-y-1"></ul>
                </div>

                <button
                    type="button"
                    id="btnCloseSuccess"
                    class="mt-2 bg-[#5a6b47] hover:bg-[#4a5939] text-white px-8 py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95 shadow-sm"
                >
                    Entendido
                </button>
            </div>

        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const profileForm = document.getElementById('profileForm');

        // Validar tipo de archivo y tamaño
        function validateImage(file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            const maxSize = 2048 * 1024; // 2MB

            if (!validTypes.includes(file.type)) {
                showNotification('Por favor selecciona un formato válido (JPEG, PNG, GIF)', 'error');
                return false;
            }

            if (file.size > maxSize) {
                showNotification('La imagen no puede superar 2MB', 'error');
                return false;
            }

            return true;
        }

        // Mostrar notificación
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-5 right-5 px-6 py-3 rounded-lg text-white font-medium z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Actualizar avatar en navbar
        function updateNavbarAvatars(imageDataUrl) {
            const navbarDesktop = document.getElementById('navbarAvatarDesktop');
            const navbarMobile = document.getElementById('navbarAvatarMobile');
            
            if (navbarDesktop) {
                navbarDesktop.src = imageDataUrl;
            }
            if (navbarMobile) {
                navbarMobile.src = imageDataUrl;
            }
        }

        // Previsualizar y enviar imagen automáticamente
        avatarInput.addEventListener('change', async function(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!validateImage(file)) {
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const imageDataUrl = e.target.result;
                avatarPreview.style.backgroundImage = `url(${imageDataUrl})`;
                avatarPreview.style.backgroundSize = 'cover';
                avatarPreview.style.backgroundPosition = 'center';
                avatarPreview.innerHTML = '';
                avatarPreview.style.backgroundColor = 'transparent';
                avatarPreview.style.opacity = '0.7';
                updateNavbarAvatars(imageDataUrl);
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('_method', 'PUT');

            try {
                const response = await fetch('{{ route("general.profile.update") }}', {
                    method: 'POST',
                    body: formData,
                });

                avatarPreview.style.opacity = '1';

                if (response.ok) {
                    showNotification('Avatar actualizado correctamente', 'success');
                } else {
                    let msg = 'Error al actualizar el avatar';
                    try { const errData = await response.json(); msg = errData.message || msg; } catch (_) {}
                    showNotification(msg, 'error');
                }
            } catch (error) {
                // Error de red — NO recargar página, solo notificar
                console.error('Error de red al subir avatar:', error);
                avatarPreview.style.opacity = '1';
                showNotification('Error de conexión al subir el avatar', 'error');
            } finally {
                avatarInput.value = '';
            }
        });

        // Manejar envío del formulario de información personal
        profileForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const currentPassword = document.getElementById('currentPassword').value.trim();
            if (!currentPassword) {
                showNotification('Debes ingresar tu contraseña actual para confirmar los cambios', 'error');
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch('{{ route("general.profile.update") }}', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    showNotification('Información actualizada correctamente', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    const error = await response.json();
                    throw new Error(error.message || 'Error al actualizar la información');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al actualizar: ' + error.message, 'error');
            }
        });

        // Lógica para alternar entre "Ver" y "Editar"
        const btnEdit = document.getElementById('btnEditProfile');
        const btnCancel = document.getElementById('btnCancelEdit');
        const viewElements = document.querySelectorAll('.view-element');
        const editElements = document.querySelectorAll('.edit-element');

        function toggleEditMode(isEditing) {
            if (isEditing) {
                viewElements.forEach(el => el.classList.add('hidden'));
                editElements.forEach(el => el.classList.remove('hidden'));
            } else {
                editElements.forEach(el => el.classList.add('hidden'));
                viewElements.forEach(el => el.classList.remove('hidden'));
            }
        }

        btnEdit.addEventListener('click', () => toggleEditMode(true));
        btnCancel.addEventListener('click', () => toggleEditMode(false));


        // ============================================================
        // ===== LÓGICA: MODAL CONVERTIRSE EN VENDEDOR =====
        // ============================================================

        const btnBecomeSeller    = document.getElementById('btnBecomeSeller');
        const sellerModal        = document.getElementById('sellerModal');
        const btnCloseModal      = document.getElementById('btnCloseSellerModal');
        const btnCancelModal     = document.getElementById('btnCancelSellerModal');
        const btnSubmit          = document.getElementById('btnSubmitSellerRequest');
        const sellerFormState    = document.getElementById('sellerFormState');
        const sellerSuccessState = document.getElementById('sellerSuccessState');

        // Marcar label como selected cuando se activa el checkbox
        document.querySelectorAll('.market-check').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const label = this.closest('.market-checkbox-label');
                if (this.checked) {
                    label.classList.add('selected');
                } else {
                    label.classList.remove('selected');
                }
            });
        });

        // Abrir modal
        if (btnBecomeSeller) {
            btnBecomeSeller.addEventListener('click', function() {
                sellerModal.classList.remove('hidden');
                // Forzar reflow antes de añadir .modal-open para que la animación arranque limpia
                sellerModal.offsetHeight;
                sellerModal.classList.add('modal-open');
                document.body.style.overflow = 'hidden';
                sellerFormState.classList.remove('hidden');
                sellerSuccessState.classList.add('hidden');
            });
        }

        // Cerrar modal (X y Cancelar)
        function closeModal() {
            sellerModal.classList.remove('modal-open');
            sellerModal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (btnCloseModal)  btnCloseModal.addEventListener('click', closeModal);
        if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

        // Cerrar al hacer click fuera del box
        sellerModal.addEventListener('click', function(e) {
            if (e.target === sellerModal) closeModal();
        });

        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !sellerModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Enviar solicitud
        if (btnSubmit) {
            btnSubmit.addEventListener('click', async function() {

                const checked = document.querySelectorAll('.market-check:checked');
                if (checked.length === 0) {
                    showNotification('Selecciona al menos un mercadillo para continuar', 'error');
                    return;
                }

                // Recoger datos para enviar al back-end
                const marketIds    = Array.from(checked).map(c => c.value);
                const marketLabels = Array.from(checked).map(c => {
                    const label = c.closest('.market-checkbox-label');
                    return label ? label.querySelector('.font-semibold')?.textContent.trim() : c.value;
                });

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                               || document.querySelector('input[name="_token"]')?.value
                               || '';

                // Estado de carga
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = `
                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Enviando...
                `;

                try {
                    /**
                     * Ruta sugerida en routes/web.php:
                     *   Route::post('/general/profile/become-seller', [ProfileController::class, 'becomeSeller'])
                     *        ->name('general.profile.become-seller')
                     *        ->middleware('auth');
                     *
                     * El controlador recibirá:
                     *   $request->input('flea_market_ids') → array de IDs de FleaMarket
                     *
                     * Devolver JSON: { "success": true } en caso de éxito
                     *           o  { "success": false, "message": "..." } en caso de error
                     */
                    const response = await fetch('example', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ flea_market_ids: marketIds }),
                    });

                    const data = await response.json();

                    if (response.ok && data.success !== false) {
                        showSuccessState(marketLabels);
                    } else {
                        throw new Error(data.message || 'Error al enviar la solicitud');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Error al enviar la solicitud: ' + error.message, 'error');
                } finally {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Enviar solicitud
                    `;
                }
            });
        }

        // Mostrar pantalla de éxito dentro del modal
        function showSuccessState(marketLabels) {
            sellerFormState.classList.add('hidden');

            const successState = document.getElementById('sellerSuccessState');
            const itemsList    = document.getElementById('successMarketItems');

            itemsList.innerHTML = marketLabels.map(name => `
                <li class="flex items-center gap-2 text-sm text-[#3d4530] font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#5a6b47] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    ${name}
                </li>
            `).join('');

            successState.classList.remove('hidden');

            // Re-lanzar animación del check
            const checkEl = successState.querySelector('.success-check');
            if (checkEl) {
                checkEl.style.animation = 'none';
                checkEl.offsetHeight; // reflow
                checkEl.style.animation = '';
            }
        }

        // Cerrar modal desde botón "Entendido"
        const btnCloseSuccess = document.getElementById('btnCloseSuccess');
        if (btnCloseSuccess) {
            btnCloseSuccess.addEventListener('click', function() {
                closeModal();
                // Ocultar el banner "Convertirse en vendedor" tras enviar
                const bannerSection = btnBecomeSeller?.closest('.mt-6, .mt-8');
                if (bannerSection) {
                    bannerSection.style.transition = 'opacity 0.4s';
                    bannerSection.style.opacity = '0.4';
                    bannerSection.style.pointerEvents = 'none';
                }
            });
        }
    });
    </script>
@endsection