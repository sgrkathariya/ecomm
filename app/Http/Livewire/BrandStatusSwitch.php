<?php

namespace App\Http\Livewire;

use App\Brand;
use Livewire\Component;

class BrandStatusSwitch extends Component
{
    public $brand;
    public $active;

    public function mount(Brand $brand)
    {
        $this->brand = $brand;
        $this->active = $brand->active;
    }

    public function updatedActive($value)
    {
        $this->brand->update(['active' => $value]);
    }
    public function render()
    {
        return view('livewire.brand-status-switch');
    }
}
