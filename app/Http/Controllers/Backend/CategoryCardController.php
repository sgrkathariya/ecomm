<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\CategoryCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryCardController extends Controller
{
    public function index(CategoryCard $CategoryCard = null)
    {
        $CategoryCards = CategoryCard::positioned()->get();
        $categories = Category::whereNotIn('id', function ($query) {
            $query->select('category_id')->from('category_cards');
        })->where('parent_id', null)->latest()->get();

        if (!$CategoryCard) {
            $CategoryCard = new CategoryCard();
        }

        return view('category-card.index', compact([
            'CategoryCards',
            'categories',
            'CategoryCard'
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
        ]);

        $CategoryCard = new CategoryCard();
        $CategoryCard->category_name = 'catalog_Card';
        $CategoryCard->category_id = $request->category_id;
        $CategoryCard->display_name = $request->display_name ?? Category::find($request->category_id)->name;
        $CategoryCard->position = 100;
        $CategoryCard->save();

        return redirect()->back()->with('success', 'Item added to Card');
    }

    public function sort(Request $request)
    {
        $cardItems = json_decode(json_encode($request->cardItems));

        foreach ($cardItems as $cardItem) {
            CategoryCard::whereId($cardItem->id)->update(['position' => $cardItem->position]);
        }

        return response()->json(['message' => 'Card has been sorted'], 200);
    }

    public function removeItem(Request $request)
    {
        CategoryCard::find($request->id)->delete();

        return response()->json(['message' => 'Item removed'], 200);
    }
}
