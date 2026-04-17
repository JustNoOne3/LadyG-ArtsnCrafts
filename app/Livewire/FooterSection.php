<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Footer;
use App\Models\Branch;

class FooterSection extends Component
{
    public function render()
    {
        $footer = Footer::first();
        $branches = Branch::all();
        return view('livewire.footer-section', compact('footer', 'branches'));
    }
}
