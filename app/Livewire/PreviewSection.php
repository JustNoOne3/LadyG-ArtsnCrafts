<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Brand;

class PreviewSection extends Component
{
    public $brands;
    public $currentBrandIndex = 0;
    public $leftProducts = [];
    public $rightProducts = [];
    public $leftBrand;
    public $rightBrand;


    public function mount(): void
    {
        $this->brands = Brand::all();
        $this->setProductsForCurrentBrands();
    }
    
    protected $listeners = ['switchCategory'];

    public function switchCategory()
    {
        $this->currentBrandIndex = ($this->currentBrandIndex + 2) % $this->brands->count();
        $this->setProductsForCurrentBrands();
    }

    private function setProductsForCurrentBrands()
    {
        $brandCount = $this->brands->count();
        $leftIndex = $this->currentBrandIndex;
        $rightIndex = ($this->currentBrandIndex + 1) % $brandCount;
        $this->leftBrand = $this->brands[$leftIndex];
        $this->rightBrand = $this->brands[$rightIndex];

        $this->leftProducts = Product::where('product_brand', $this->leftBrand->id)
            ->orderByDesc('product_soldCount')
            ->take(4)
            ->get();
        $this->rightProducts = Product::where('product_brand', $this->rightBrand->id)
            ->orderByDesc('product_soldCount')
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.preview-section');
    }
}
