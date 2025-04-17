<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function createUser(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect('/mypage/profile');
    }

    public function email()
    {
        return view('auth.verify-email');
    }

    public function address()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $first = is_null($user->post_code) && is_null($user->address) && is_null($user->building);
        $user->update([
            'name' => $request->name ?? $user->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        if ($first) {
            Auth::logout();
            return redirect('/login');
        }
        return redirect('/mypage');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginUser(LoginRequest $request)
    {
        $user = $request->only([
            'email',
            'password',
        ]);
        if(Auth::attempt($user)){
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors([
            'email' => '認証情報と一致するレコードがありません。',
        ])->withInput();
    }

}
