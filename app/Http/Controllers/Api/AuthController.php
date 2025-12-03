<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('bank-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'expires_in_minutes' => 4320  // 72 soat
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Noto‘g‘ri login yoki parol'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('bank-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'expires_in_minutes' => 4320  // 72 soat
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Muvaffaqiyatli chiqildi']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
