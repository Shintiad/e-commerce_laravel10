<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register()
    {
        return view("auth/register");
    }

    public function registerStore(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|max:255',
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'address' => 'required|max:255',
            'phone' => 'required|unique:users'
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('login');
    }

    public function login()
    {
        return view("auth/login");
    }

    public function loginStore(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('home');
        } else {
            return back()->withInput()->with('error', 'Email atau password salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}