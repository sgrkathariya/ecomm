<?php

namespace App\View\Components;

use App\Brand;
use Illuminate\View\Component;

class BrandCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $brands = Brand::orderBy('name')->limit(10)->get()->shuffle();
        return view('components.brand-card',compact('brands'));
    }
}
