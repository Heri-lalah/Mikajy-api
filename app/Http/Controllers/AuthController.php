<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validation = $request->validate([
            'name' => ['required'],
            'pseudo' => ['required', 'unique:users,pseudo', 'regex:(^[a-zA-Z0-9])', 'max:15'],
            'phone_number' =>['required'],
            'password' =>['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $user = User::create($validation);

        $token = $user->createToken('_token')->plainTextToken;

        return response()->json(['_token' => $token, 'message' => "Authentication successfully"], 201);

    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'pseudo' => ['required', 'unique:users,pseudo', 'regex:(^[a-zA-Z0-9])', 'max:15'],
            'password' => ['required', 'min:6']
        ]);
    }
}
