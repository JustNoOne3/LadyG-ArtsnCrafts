<?php

namespace App\Livewire;

use Livewire\Component;

class NavigationBar extends Component
{
    public function render()
    {
        return view('livewire.navigation-bar');
    }

    public function logoutModal()
    {
        $this->dispatch('open-modal', id: 'logout-modal');
    }
}
