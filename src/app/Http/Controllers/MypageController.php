<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('mylist', compact('items'));
    }

    public function detail($itemId)
    {
        $item = Item::with('categories','condition')->find($itemId);
        $conditions = Condition::all();
        $categories = Category::with('items')->get();
        $categoryIds = $item->categories->pluck('id')->toArray();
        return view('detail', compact('item', 'conditions', 'categories', 'categoryIds'));
    }


    public function profile()
    {
        return view('mypage.profile');
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user()->update([
            'name' => $request->name ?? $user->name,
            'post_code' => $request->post_code ?? $request->post_code,
            'address' => $request->address ?? $request->address,
            'building' => $request->building ?? $request->building,
        ]);
        return redirect('/mypage/profile');
    }

    public function mypage()
    {
        return view('mypage.mypage');
    }
}
