<?php

namespace App\Livewire;

use Livewire\Component;

class LogoutModal extends Component
{
    public function render()
    {
        return view('livewire.logout-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', id: 'logout-modal');
    }
    
}
