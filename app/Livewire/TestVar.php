<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class TestVar extends Component
{
    public $users;
    public function render()
    {
        return view('livewire.test-var');
    }

    public function mount()
    {
        $users = User::all()->count();
        $this->users = $users;
    }
}
