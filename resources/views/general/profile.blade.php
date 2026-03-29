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

            <livewire:become-seller-modal :user="$user" />
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
    });
    </script>
@endsection