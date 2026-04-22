<?php

namespace App\Livewire;

use Livewire\Component;

class CompressedNavigation extends Component
{
    public function render()
    {
        return view('livewire.compressed-navigation');
    }

    public function logoutModal()
    {
        $this->dispatch('open-modal', id: 'logout-modal');
    }
}
