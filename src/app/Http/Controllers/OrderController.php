<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function purchase($itemId)
    {
        $user = Auth::user();
        $item = Item::all()->find($itemId);
        return view('order.purchase', compact('user', 'item'));
    }

    public function shippingAddress($itemId)
    {
        $user = Auth::user();
        $item = Item::find($itemId);
        return view('order.address', compact('user', 'item'));
    }

    public function edit(AddressRequest $request, $itemId)
    {
        $user = Auth::user();
        $item = Item::find($itemId);
        $request->session()->put('shipping_post_code', $request->shipping_post_code);
        $request->session()->put('shipping_address', $request->shipping_address);
        $request->session()->put('shipping_building', $request->shipping_building);
        return redirect("/purchase/{$itemId}");
    }

    public function store(PurchaseRequest $request, $itemId)
    {
        $user = Auth::user();
        $item = Item::find($itemId);
        Order::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'shipping_post_code' => session('shipping_post_code', $user->post_code),
            'shipping_address' => session('shipping_address', $user->address),
            'shipping_building' => session('shipping_building', $user->building),
            'pay' => $request->pay,
        ]);
        session()->forget([
            'shipping_post_code',
            'shipping_address',
            'shipping_building',
        ]);
        return redirect('/');
    }
}
