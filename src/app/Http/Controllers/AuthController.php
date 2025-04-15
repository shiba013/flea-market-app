<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use App\Models\User;
use App\Models\Item;
use App\Http\Requests\AddressRequest;

class AuthController extends Controller
{
    public function email()
    {
        return view('auth/verify-email');
    }

    public function address()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function store(AddressRequest $request)
    {
        $user = Auth::user()->update([
            'name' => $request->name ?? $user->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        Auth::logout();
        return redirect('/login');
    }

    public function mylist()
    {
        $items = Item::all();
        return view('mylist', compact('items'));
    }
}
