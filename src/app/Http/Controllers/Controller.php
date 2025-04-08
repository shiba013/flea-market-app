<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
