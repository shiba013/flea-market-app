<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            return $this->mylist();
            return $this->detail();
        }
        return $this->index();
        return $this->introduction();
    }

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
        $user = Auth::user();
        $tab = $request->query('tab');
        $items = Item::all();
        return view('mylist', compact('tab', 'items'));
    }

    public function detail($itemId)
    {
        $item = Item::with('categories', 'condition')->find($itemId);
        $conditions = Condition::all();
        return view('detail', compact('item', 'conditions'));
    }

    public function mypage(Request $request)
    {
        $tab = $request->query('tab');
        $items = Item::all();
        $user = Auth::user();
        return view('mypage.mypage', compact('tab', 'items', 'user'));
    }
}
