<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreRegister;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected function generateAccessToken($user)
    {
        $token = $user->createToken($user->email . '-' . now());

        return $token->accessToken;
    }
    // Registration Controller Function
    public function register(StoreRegister $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'lga' => $request->lga,
            'state' => $request->state,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(
            [
                "message" => "account created successfully",
                "success" => true,
                "data" => $user
            ],
            201
        );
    }

    // Login Controller Function
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return response(['message' => 'invalid login credentials.',  'success' => false], 400);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['data' => Auth::user(), 'token' => $accessToken, 'message' => 'login successful', 'success' => true], 200);
    }
}
