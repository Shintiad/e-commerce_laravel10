<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function role(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = $request->user();
        
        if ($user->role == 1) {
            return response()->json(['role' => 'admin']);
        } elseif ($user->role == 0) {
            return response()->json(['role' => 'user']);
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }
    }
}