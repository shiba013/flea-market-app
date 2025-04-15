<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function purchase()
    {
        $user = User::all();
        $items = Item::all();
        return view('order.purchase', compact('user','items'));
    }

    public function store(PurchaseRequest $request)
    {
        $user = User::find($request->id);
        $item = Item::find($request->id);
        //
        return view('mylist');
    }

    public function shippingAddress()
    {
        $user = Auth::user();
        $items = Item::all();
        return view('order.address', compact('user','items'));
    }

    public function edit(PurchaseRequest $request)
    {
        $user = User::find($request->id);
        $address = $request->only([
            'shipping_post_code',
            'shipping_address',
            'shipping_building',
        ]);
        Order::create($address);
        return view('order.purchase');
    }
}
