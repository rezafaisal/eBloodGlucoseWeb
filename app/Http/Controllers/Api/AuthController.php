<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->status === 'registered') {
            return response()->json(['message' => 'Status Akun Belum Aktif'], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        unset($user->id);

        return response()
            ->json([
                'message' => 'Login Berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
    }
}
