<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationController extends Controller
{
    //

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Account Created Successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Logged in Successfully.',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully Logged out',
        ], 200);
    }
}
