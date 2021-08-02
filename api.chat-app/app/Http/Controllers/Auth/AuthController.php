<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $data = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        if (auth()->attempt($request->only(['email', 'password']))) {
            return abort(401);
        }

        return response()->json([
            'data' => $data,
            'meta' => [
                'token' => $data->createToken('API Token')->plainTextToken
            ]
        ]);
        // return (new UserResource($user))->additional([
        //     'meta' => [
        //         'token' => $user->createToken('API Token')->plainTextToken
        //     ]
        // ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return response()->json([
                'message' => 'The given credentials is invalid'
            ], 401);
            // return ResponseFormatter::error(null, 'Credentials not match', 401);
        }

        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
        // return ResponseFormatter::success([
        //     'token' => auth()->user()->createToken('API Token')->plainTextToken
        // ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
