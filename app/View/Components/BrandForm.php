<?php

namespace App\View\Components;

use App\Brand;
use Illuminate\View\Component;

class BrandForm extends Component
{
    public $brand;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $brands = Brand::active()->orderBy('name')->get();

        return view('components.brand-form',compact('brands'));
    }
}
