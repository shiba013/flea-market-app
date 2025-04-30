<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Condition;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Order;
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
        return view('my_list', compact('tab', 'items'));
    }

    public function introduction($itemId)
    {
        $conditions = Condition::all();
        $item = Item::with(['categories', 'condition'])
        ->withCount(['likes as is_liked' => function($query)
        {
            $query->where('user_id', auth()->id());
        }])->find($itemId);

        $commented = Comment::where('item_id', $itemId)
        ->where('user_id', auth()->id())
        ->exists();
        return view('detail', compact('conditions', 'item', 'commented'));
    }

    public function mylist(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab');

        if ($tab == 'mylist') {
            $items = $user->LikedItems()
                ->with('likes')
                ->where('items.user_id', '!=', $user->id)
                ->get();
        } else {
            $items = Item::with('likes')->where('user_id', '!=', $user->id)->get();
        }

        if ($request->query('status') == 'success') {
            session()->flash('message', '支払いが完了しました');
        } elseif($request->query('status') == 'fail') {
            session()->flash('fail', '支払いができませんでした');
        }

        session()->forget(['shipping_post_code', 'shipping_address', 'shipping_building']);

        return view('my_list', compact('tab', 'items'));
    }

    public function detail($itemId)
    {
        $conditions = Condition::all();
        $item = Item::with(['categories', 'condition'])
        ->withCount(['likes as is_liked' => function($query)
        {
            $query->where('user_id', auth()->id());
        }])->find($itemId);
        $commented = Comment::where('item_id', $itemId)
        ->where('user_id', auth()->id())
        ->exists();

        return view('detail', compact('conditions', 'item', 'commented'));
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

    public function comment(CommentRequest $request, $itemId)
    {
        Comment::updateOrCreate([
            'user_id' => auth()->id(),
            'item_id' => $itemId,
            'comment' => $request->comment,
        ]);
        return redirect("/item/{$itemId}");
    }

    public function mypage(Request $request)
    {
        $tab = $request->query('tab');
        $user = Auth::user();

        if ($tab == 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } else {
            $items = Item::whereIn('id', Order::where('user_id', $user->id)->pluck('item_id'))
            ->where('is_sold', 1)->get();
        }
        return view('my_page.my_page', compact('tab', 'items', 'user'));
    }

    public function search(Request $request)
    {
        $tab = $request->query('tab');
        $items = collect();

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $likedItemIds = Like::where('user_id', Auth::id())->pluck('item_id');
                $items = Item::whereIn('id', $likedItemIds)->with('likes')
                ->KeywordSearch($request->keyword)->get();
            } else {
                $items = $user->LikedItems()->with('likes')
                ->KeywordSearch($request->keyword)->get();
            }
        } else {
            $items = Item::with('likes')
            ->KeywordSearch($request->keyword)->get();
        }
        return view('my_list', compact('tab', 'items'));
    }
}