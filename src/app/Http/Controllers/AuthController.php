<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
        return redirect('/email/verify');
    }

    public function email(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
        }
        return view('auth.verify-email');
    }

    public function verification(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/my_page.profile');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/my_page.profile');
        }
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function address()
    {
        $user = Auth::user();
        return view('my_page.profile', compact('user'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $first = is_null($user->post_code) && is_null($user->address) && is_null($user->building);
        $data = [
            'name' => $request->name ?? $user->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('images', $image_name, 'public');
            $data['image'] = 'storage/images/' . $image_name;
        };
        $user->update($data);

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
            'email' => 'ログイン情報が登録されていません',
        ])->withInput();
    }

}
