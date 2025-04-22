<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class TransactionController extends Controller
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

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $product = \Stripe\Product::create([
            'name' => $item->name,
            'description' => $item->description,
            //'images' => $image_name, // 画像URLを設定
        ]);

        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $item->price,
            'currency' => 'jpy',
        ]);

        $item->update([
            'stripe_item_id' => $product->id,
            'stripe_price_id' => $price->id,
        ]);
        return redirect('/')->with('message', '出品が完了しました');
    }

    public function purchase($itemId)
    {
        $user = Auth::user();
        $item = Item::all()->find($itemId);

        if ($item->is_sold) {
            return redirect("/item/$itemId")->with('error', 'この商品はすでに購入されています');
        }

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
        Stripe::setApiKey(config('services.stripe.secret'));

        if($request->pay == 1) {
            $payMethod = 'konbini';
        } else {
            $payMethod = 'card';
        }

        $checkout = Session::create([
            'payment_method_types' => [$payMethod],
            'line_items' => [[
                'price' => $item->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/') . '?status=success',
            'cancel_url' => 'https://example.com/cancel',
            'metadata' => [
                'user_id' => $user->id,
                'item_id' => $itemId,
                'shipping_post_code' => session('shipping_post_code', $user->post_code),
                'shipping_address' => session('shipping_address', $user->address),
                'shipping_building' => session('shipping_building', $user->building),
                'pay' => $payMethod,

            ],
        ]);
        return redirect($checkout->url);
    }
}
