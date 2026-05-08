<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Branch;
use Illuminate\Support\Facades\Session;

class BranchSelector extends Component
{
    public $selectedBranch;
    public $showModal = false;
    public $branches = [];

    public function mount()
    {
        $this->branches = Branch::all();
        $this->selectedBranch = session()->get('selected_branch');
        if (empty($this->selectedBranch)) {
            $this->showModal = true;
        }
    }

    public function selectBranch($branchId)
    {
        $branch = Branch::find($branchId);
        if ($branch) {
            $this->selectedBranch = $branch->id;
            session()->put('selected_branch', $branch->id);
        } else {
            $this->selectedBranch = null;
            session()->forget('selected_branch');
        }
        $this->showModal = false;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function render()
    {
        $currentBranch = $this->selectedBranch ? Branch::find($this->selectedBranch) : null;
        return view('livewire.branch-selector', [
            'branches' => $this->branches,
            'currentBranch' => $currentBranch,
            'showModal' => $this->showModal,
        ]);
    }
}
