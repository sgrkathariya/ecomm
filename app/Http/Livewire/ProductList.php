<?php

namespace App\Http\Livewire;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $paginate = 15;
    protected $paginationTheme = 'bootstrap';

    public $filter = [
        'name' => null,
        'category_id' => 'all',
        'brand_id' => 'all',
        'status' => true,
    ];

    public $categories;
    public $brands;

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }

    public function search()
    {
        //
    }

    public function render()
    {
        $products = Product::with(['category', 'brand']);
        $products = $this->filter($products)
            ->latest()
            ->paginate($this->paginate);

        return view('livewire.product-list', [
            'products' => $products
        ]);
    }

    private function filter(Builder $products)
    {
        if ($this->filter['name']) {
            $products = $products->whereName($this->filter['name']);
        }

        if ($this->filter['category_id'] && $this->filter['category_id'] != 'all') {
            $products = $products->where('category_id', $this->filter['category_id']);
        }
        if ($this->filter['brand_id'] && $this->filter['brand_id'] != 'all') {
            $products = $products->where('brand_id', $this->filter['brand_id']);
        }

        if ($this->filter['status'] != 'all') {
            if ($this->filter['status'] == 'active') {
                $products = $products->active(true);
            }

            if ($this->filter['status'] == 'inactive') {
                $products = $products->active(false);
            }
            // $products = $products->active((bool)$this->filter['status'] ? true : false);
        }

        return $products;
    }
}
