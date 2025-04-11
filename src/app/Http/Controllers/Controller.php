<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Condition;
use App\Models\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('mylist');
    }

    public function item()
    {
        return view('detail');
    }

    public function profile()
    {
        return view('mypage/profile');
    }

    public function email()
    {
        return view('auth/verify-email');
    }

    public function detail()
    {
        return view('detail');
    }

    public function mypage()
    {
        return view('mypage/mypage');
    }

    public function sell()
    {
        $conditions = Condition::all();
        $categories = Category::all();
        return view('sell/sell', compact('conditions', 'categories'));
    }

    public function purchase()
    {
        return view('order/purchase');
    }

    public function address()
    {
        return view('order/address');
    }
}
