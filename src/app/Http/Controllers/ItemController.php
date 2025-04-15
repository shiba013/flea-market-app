<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function sell()
    {
        $conditions = Condition::all();
        $categories = Category::all();
        return view('sell/sell', compact('conditions', 'categories'));
    }
}
