<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register
    public function register(REQUEST $request)
    {
        $att = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:6']
        ]);
        $att['password'] = bcrypt($att['password']);
        $user = User::create($att);
        auth()->login($user);
        return response()->json([
            'user' => $user->name,
            'token' => $user->createToken('apiToken')->plainTextToken
        ]);
    }

    //login
    public function login(REQUEST $request)
    {

        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect username or password'
            ], 401);
        }
        $token = $user->createToken('apiToken')->plainTextToken;
        return response()->json([
            'user' => $user->name,
            'token' => $token
        ], 401);
    }

    public function logout(REQUEST $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}
