<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Service\ImageService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware('role:super-admin|admin');
    }

    public function index(Brand $brand = null)
    {
        if (!$brand) {
            $brand = new Brand();
        }

        $brands = Brand::orderBy('name')->get();

        return view('brand.index', compact('brand', 'brands'));
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $imgaepath = $this->imageService->storeImage($request->file('thumbnail'));
            $data['thumbnail'] = $imgaepath;
        }

        $brand = Brand::create($data);

        return redirect()->back()->with('success', 'Brand has been added');
    }


    public function edit(Brand $brand)
    {
        return $this->index($brand);
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        if($request->thumbnail){
            if ($brand->thumbnail) {
                $this->imageService->unlinkImage($brand->thumbnail);
            }
            $imgaepath = $this->imageService->storeImage($request->file('thumbnail'));
            $data['thumbnail'] = $imgaepath;
        }
        $brand = $brand->update($data);
        return redirect()->route('brands.index')->with('success', 'Brand has been updated');
    }

    public function destroy(brand $brand)
    {


        $this->imageService->unlinkImage($brand->thumbnail);
        // soft delete the brand
        $brand->delete();

        return redirect()->back()->with('success', 'brand has been deleted');
    }
}
