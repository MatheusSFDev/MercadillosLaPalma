<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public function switchRole($role)
    {
        $user = Auth::user();
        if ($user && $user->setCurrentRole($role)) {
            // Use JavaScript to reload the page after role change
            $this->dispatch('role-changed');
        }
    }

    public function render()
    {
        return view('livewire.layout.navbar');
    }
}