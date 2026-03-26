<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateSettingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $settings = $request->user()->settings;

        if (!$settings) {
            $settings = $request->user()->settings()->create();
        }

        return response()->json([
            'message'  => 'Data Setting Berhasil Diambil',
            'settings' => [
                'fasting_start_at' => optional($settings->fasting_start_at)?->format('H:i'),
                'breakfast_at'     => optional($settings->breakfast_at)?->format('H:i'),
                'updated_at'       => $settings->updated_at,
            ],
        ]);
    }

    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $user = $request->user();
        $settings = $user->settings ?: $user->settings()->create();

        $data = $request->validated();

        $settings->fill($data)->save();

        return response()->json([
            'message'  => 'Settings berhasil diperbarui',
            'settings' => [
                'fasting_start_at' => optional($settings->fresh()->fasting_start_at)?->format('H:i'),
                'breakfast_at'     => optional($settings->breakfast_at)?->format('H:i'),
                'updated_at'       => $settings->updated_at,
            ],
        ]);
    }
}
