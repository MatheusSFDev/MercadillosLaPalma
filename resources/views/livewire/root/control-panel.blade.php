{{-- ÚNICO ELEMENTO RAÍZ --}}
<div class="p-6 md:p-12 bg-[#e9f0d6] min-h-screen font-sans text-slate-800" x-data="{ searching: false }">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
        <div>
            <h1 class="text-5xl font-playfair font-black tracking-tight text-slate-900">
                Panel de Control <span class="text-sm font-mono font-normal bg-white/50 px-2 py-1 rounded ml-2 border border-slate-200">root_access</span>
            </h1>
            <p class="mt-2 text-slate-600 italic">Gestión de jerarquías y permisos del sistema.</p>
        </div>
        
        <div class="flex gap-4">
            <div class="bg-white/60 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white shadow-sm text-right">
                <span class="text-sm uppercase tracking-widest text-slate-500 font-bold">Total Usuarios</span>
                <p class="text-3xl font-playfair font-bold text-primary">{{ $users->count() }}</p>
            </div>
        </div>
    </div>

    <div class="mb-8 flex flex-col md:flex-row gap-4 items-center bg-white/40 p-4 rounded-2xl border border-white/50 shadow-inner">
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input 
                wire:model.live="search" 
                type="text" 
                placeholder="Buscar por nombre o email..." 
                class="w-full pl-10 pr-4 py-3 rounded-xl border-none bg-white/80 focus:ring-2 focus:ring-primary shadow-sm"
            >
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            <span class="text-xs font-bold uppercase text-slate-500 mr-2 whitespace-nowrap">Filtrar por:</span>
            <select wire:model.live="roleFilter" class="rounded-xl border-none bg-white/80 focus:ring-2 focus:ring-primary shadow-sm text-sm py-3 px-8">
                <option value="">Todos los roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Notificaciones --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             class="mb-6 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-md transition-all">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Grid de Usuarios --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6" wire:loading.class="opacity-60">
        @forelse ($users->sortByDesc(fn($u) => $u->hasRole('root')) as $user)
            <div class="bg-white/80 backdrop-blur hover:bg-white transition-all duration-300 p-6 rounded-3xl shadow-sm border {{ $user->hasRole('root') ? 'border-primary/40 ring-2 ring-primary/10' : 'border-white/50' }} group relative">
                
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl {{ $user->hasRole('root') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#e9f0d6] text-primary' }} flex items-center justify-center font-bold text-lg border border-primary/10">
                            {{ substr($user->name, 0, 1) }}{{ substr($user->surname, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="text-lg font-bold text-slate-900 leading-tight">{{ $user->name }} {{ $user->surname }}</p>
                                @if($user->hasRole('root'))
                                    <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Root</span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    @if ($user->id !== auth()->id() && !$user->hasRole('root'))
                        <button
                            wire:click="deleteUser({{ $user->id }})"
                            wire:confirm="¿Deseas eliminar permanentemente a este usuario?"
                            class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors p-2.5 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    @endif
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 italic">Privilegios</p>
                        <div wire:loading wire:target="updateRoles({{ $user->id }})">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 items-center">
                        @foreach ($roles as $role)
                            @php
                                $isRootRole = $role->name === 'root';
                                $canToggle = !$isRootRole;
                            @endphp

                            <label class="relative flex items-center {{ $canToggle ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                <input
                                    type="checkbox"
                                    wire:model="selectedRoles.{{ $user->id }}"
                                    value="{{ $role->name }}"
                                    class="peer sr-only"
                                    @disabled(!$canToggle)
                                >
                                <div class="px-4 py-2 rounded-xl border-2 border-slate-100 text-[13px] font-medium transition-all
                                            peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary
                                            {{ $canToggle ? 'hover:border-primary/30' : '' }} bg-white shadow-sm">
                                    {{ ucfirst($role->name) }}
                                    @if($isRootRole) <span class="ml-1 opacity-50 text-[10px]">🔒</span> @endif
                                </div>
                            </label>
                        @endforeach

                        <button
                            wire:click="updateRoles({{ $user->id }})"
                            wire:loading.attr="disabled"
                            class="ml-auto flex items-center gap-2 bg-slate-900 hover:bg-black px-6 py-2.5 text-white text-sm font-bold rounded-xl transition-all active:scale-95 disabled:opacity-50">
                            <span wire:loading.remove wire:target="updateRoles({{ $user->id }})">Actualizar</span>
                            <span wire:loading wire:target="updateRoles({{ $user->id }})">...</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white/40 rounded-3xl border border-dashed border-slate-400">
                <p class="text-slate-500 font-medium italic">No se encontraron usuarios.</p>
            </div>
        @endforelse
    </div>

    {{-- Estilos inyectados dentro del elemento raíz --}}
    <style>
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-bounce-short {
            animation: bounce-short 1s ease-in-out 1;
        }
    </style>
</div> {{-- FIN DEL ELEMENTO RAÍZ --}}