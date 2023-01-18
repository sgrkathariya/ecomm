<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Error;

class ProductController extends Controller
{
    use SEOToolsTrait;

    public function index()
    {
        $filter = [];
        $products =new Product;

        if (request()->has('category')) {
            $category = Category::whereSlug(request('category'))->first();
            if ($category) {
                $filter['category'] = $category;
                $ids = Category::where('parent_id', $category->id)->get()->pluck('id')->toArray();
                array_push($ids, $category->id);
                $products = $products->whereIn('category_id', $ids);
                // Here we get some related categories
                $relatedCategories = Category::Where('parent_id', $category->parent_id)->limit(7)->get();
            }
        }
        if (request()->has('brand')) {
            $brand = Brand::whereSlug(request('brand'))->first();
            if ($brand) {
                $filter['brand'] = $brand;
                $products = $products->where('brand_id', $brand->id);
            }
        }

        if (request()->has('pname')) {
            $filter['pname'] = request()->get('pname');
            $products = $products->orWhere('name', 'like', '%' . request()->input('pname') . '%');
        }

        // filter for minimun price
        if (request()->has('min_price') && !is_null(request()->get('min_price'))) {
            $filter['min_price'] = request()->get('min_price');
            $product = $products->where(function ($query) {
                return $query->addSelect(\DB::raw('COALESCE(`sale_price`, `regular_price`)'));
            }, '>=', request()->get('min_price'));
        }

        // filter for maximun price
        if (request()->has('max_price') && !is_null(request()->get('max_price'))) {
            $filter['max_price'] = request()->get('max_price');
            $product = $products->where(function ($query) {
                return $query->addSelect(\DB::raw('COALESCE(`sale_price`, `regular_price`)'));
            }, '<=', request()->get('max_price'));
        }

        // filter by rating
        if (request()->has('min_rating') && !is_null(request()->get('min_rating'))) {
            $products = $products->whereHas('ratings', function ($query) {
                return $query->havingRaw('AVG(rating) >= ?', [request()->min_rating]);
            });
        }

        if (request()->has('sort')) {
            if (request()->get('sort') == "price-lth") {
                $products = $products->orderBy('sale_price');
            } elseif (request()->get('sort') == "price-htl") {
                $products = $products->orderBy('sale_price', 'desc');
            } else {
                $products = $products->latest();
            }
        }
        $products = $products->paginate(30);

        // declare empty relatedCategories if category was not searched for
        if (!isset($relatedCategories)) {
            $relatedCategories = [];
        }

        $filter = collect($filter);

        return view('frontend.product.index', compact([
            'products',
            'relatedCategories',
            'filter'
        ]));
    }

    public function show(Product $product)
    {
        $product->load('productImages');

        $this->seo()->setTitle($product->seoTitle());
        $this->seo()->setDescription($product->seoDescription());
        $this->seo()->metatags()->addKeyword([$product->name]);
        $this->seo()->opengraph()->addImage($product->seoImage());
        $this->seo()->opengraph()->setType('product');
        $this->seo()->opengraph()->setProduct([
            'original_price:amount' => $product->regular_price,
            'original_price:currency' => priceUnit(),
            'pretax_price:amount' => $product->current_price,
            'pretax_price:currency' => priceUnit(),
            'price:amount' => $product->current_price,
            'price:currency' => priceUnit(),
            'shipping_cost:amount' => shippingCharge(),
            'shipping_cost:currency' => priceUnit(),
            'weight:value' => $product->product_weight,
            'weight:units' => null,
            'shipping_weight:value' => null,
            'shipping_weight:units' => null,
            'sale_price:amount' => $product->sale_price,
            'sale_price:currency' => priceUnit(),
            'sale_price_dates:start' => $product->sale_price_from,
            'sale_price_dates:end' => $product->sale_price_to
        ]);

        $relatedProducts = Product::active()->where('category_id', $product->category->id)->limit(5)->get();

        return view('frontend.product.show', compact('product', 'relatedProducts'));
    }

    public function byGroup($tag)
    {
        if ($tag == "top") {
            $title = 'Top Products';
            $products = Product::where('is_top', true)->latest()->limit(6)->paginate(30)->shuffle();
            return view('frontend.product.by-group', compact('products', 'title'));
        }elseif($tag == "brand"){
          return view('frontend.brand.index');
        }else{
            abort(404);
        }

    }
}
