<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function sell()
    {
        $user = Auth::user();
        $conditions = Condition::all();
        $categories = Category::all();
        return view('sell.sell', compact('conditions', 'categories'));
    }

    public function exhibit(ExhibitionRequest $request)
    {
        $user = Auth::user();
        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $image->storeAs('images', $image_name, 'public');

        $item = Item::create([
            'user_id' => $user->id,
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => 'storage/images/' . $image_name,
            'brand' => $request->brand,
        ]);
        $item->categories()->attach($request->categories);
        return redirect('/');
    }
}
