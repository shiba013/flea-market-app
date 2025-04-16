<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    //ログイン前のアクション
    public function index()
    {
        $items = Item::all();
        return view('mylist', compact('items'));
    }

    public function introduction($itemId)
    {
        $item = Item::with('categories','condition')->find($itemId);
        $conditions = Condition::all();
        return view('detail', compact('item', 'conditions'));
    }

    //ログイン後のアクション
    public function mylist(Request $request)
    {
        $tab = $request->query('tab');
        if($tab === 'mylist')
        {
            $items = Item::all();
        }
        else
        {
            $items = Item::all();
        }
        return view('mylist', compact('tab', 'items'));
    }

    public function detail($itemId)
    {
        $item = Item::with('categories', 'condition')->find($itemId);
        $conditions = Condition::all();
        return view('detail', compact('item', 'conditions'));
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
