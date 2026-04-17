<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AboutUs;

class AboutusSection extends Component
{
    public function render()
    {
        $aboutUs = AboutUs::first();
        return view('livewire.aboutus-section', compact('aboutUs'));
    }
}
