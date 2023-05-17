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
            'pseudo' => ['required'],
            'phone_number' =>['required'],
            'password' =>['required']
        ]);

        $user = User::create($validation);

        $token = $user->createToken('_token')->plainTextToken;

        return response()->json(['_token' => $token, 'message' => "Authentication successfully"], 201);

    }
}
