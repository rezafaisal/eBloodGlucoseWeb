<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user()->only([
            'name','email','age','gender','blood_type','height'
        ]);

        return response()->json([
            'message' => 'Data Profil Berhasil Diambil',
            'user' => $user,
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validated();

        $user->fill($data);
        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user->only(['name','email','age','gender','blood_type','height']),
        ]);
    }
}
