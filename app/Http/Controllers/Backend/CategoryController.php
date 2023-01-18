<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Service\ImageService;

class CategoryController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware('role:super-admin|admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category = null)
    {
        if (!$category) {
            $category = new Category();
        }

        $categories = Category::with(['childCategories.childCategories', 'author:name', 'editor:name'])->where('parent_id', null)->orderBy('name')->get();

        return view('category.index', compact('category', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $imgaepath = $this->imageService->storeImage($request->file('thumbnail'));
            $data['thumbnail'] = $imgaepath;
        }
        $category = Category::create($data);

        return redirect()->back()->with('success', 'Category has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return $this->index($category);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if($request->thumbnail){
            if ($category->thumbnail) {
                $this->imageService->unlinkImage($category->thumbnail);
            }
            $imgaepath = $this->imageService->storeImage($request->file('thumbnail'));
            $data['thumbnail'] = $imgaepath;
        }
            
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $productsCount = count($category->products);

        // do not allow deletion if it has products
        if ($productsCount) {
            return redirect()->back()->with('error', 'Sorry the category cannot be deleted since it have ' . $productsCount . ' products');
        }

        // soft delete the category
        $this->imageService->unlinkImage($category->thumbnail);
        $category->delete();

        return redirect()->back()->with('success', 'Category has been deleted');
    }
}
