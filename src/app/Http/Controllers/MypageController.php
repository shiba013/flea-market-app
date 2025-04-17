<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function home(Request $request)
    {
    return Auth::check()
        ? $this->mylist($request)
        : $this->index($request);
    }

    public function showItem($itemId)
    {
    return Auth::check()
        ? $this->detail($itemId)
        : $this->introduction($itemId);
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $items = collect();

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $likedItemIds = Like::where('user_id', Auth::id())->pluck('item_id');
                $items = Item::whereIn('id', $likedItemIds)->with('likes')->get();
            }
        } else {
            $items = Item::with('likes')->get();
        }
        return view('mylist', compact('tab', 'items'));
    }

    public function introduction($itemId)
    {
        $item = Item::with(['categories', 'condition'])
        ->withCount(['likes as is_liked' => function($query)
        {
            $query->where('user_id', auth()->id());
        }])->find($itemId);
        $conditions = Condition::all();
        return view('detail', compact('item', 'conditions'));
    }

    public function mylist(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab');
        $items = $user->LikedItems()->with('likes')->get();
        if ($tab == 'mylist') {
            $items = $user->LikedItems()->with('likes')->get();
        } else {
            $items = Item::with('likes')->get();
        }
        return view('mylist', compact('tab', 'items'));
    }

    public function detail($itemId)
    {
        $item = Item::with(['categories', 'condition'])
        ->withCount(['likes as is_liked' => function($query)
        {
            $query->where('user_id', auth()->id());
        }])->find($itemId);
        $conditions = Condition::all();
        return view('detail', compact('item', 'conditions'));
    }

    public function like($itemId)
    {
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)->where('item_id', $itemId)->first();
        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]);
        }
        return redirect("/item/{$itemId}");
    }

    public function mypage(Request $request)
    {
        $tab = $request->query('tab');
        $items = Item::all();
        $user = Auth::user();
        return view('mypage.mypage', compact('tab', 'items', 'user'));
    }
}
