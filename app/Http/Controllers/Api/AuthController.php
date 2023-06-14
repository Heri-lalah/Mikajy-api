<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validation = $request->validate([
            'name' => ['required'],
            'pseudo' => ['required', 'unique:users,pseudo', 'regex:(^[a-zA-Z0-9])'],
            'phone_number' =>['required'],
            'password' =>['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $user = User::create($validation);
        Auth::login($user);

        $token = $user->createToken('_token')->plainTextToken;
        return response()->json(['_token' => $token, 'message' => "Authentication successfully"], 201);

    }

    public function login(Request $request)
    {

        $validation = $request->validate([
            'pseudo' => ['required', 'regex:(^[a-zA-Z0-9])'],
            'password' => ['required', 'min:6']
        ]);

        if(!Auth::attempt($validation))
        {
            return response()->json(['message', 'authentication failed! Verify your pseudo or password'], 403);
        }

        return response()->json([
            'message' => 'Authentication successfull',
            '_token' => Auth::user()->createToken('_token')->plainTextToken
        ],200);
    }

    public function destroy(Request $request)
    {
        $validation = $request->validate([
            'id' => 'required',
            'password' => 'required'
        ]);

        if(!Hash::check($validation['password'], Auth::user()->password))
        {
            return response()->json(['message' => 'your password is incorrect'], 401);
        }

        $user = User::find($validation['id']);

        $user->expenses()->delete();
        $user->incomes()->delete();
        $user->delete();

        return response()->json(['message' => 'success'], 202);
    }
}
