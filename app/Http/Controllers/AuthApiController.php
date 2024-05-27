<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'username' => 'required|max:255',
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:4',
            'address' => 'required|max:255',
            'phone' => 'required|unique:users'
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function getUser(Request $request)
    {
        if ($request->user()) {
            return response()->json($request->user());
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}