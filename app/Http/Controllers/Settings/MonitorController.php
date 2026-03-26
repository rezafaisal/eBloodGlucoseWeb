<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitorController extends Controller
{
    public function edit(Request $request)
    {
        $settings = $request->user()->settings ?? $request->user()->settings()->create();

        return Inertia::render('settings/Monitor', [
            'settings' => [
                'fasting_start_at' => optional($settings->fasting_start_at)?->format('H:i'),
                'breakfast_at'     => optional($settings->breakfast_at)?->format('H:i'),
                'updated_at'       => $settings->updated_at,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'fasting_start_at' => ['nullable', 'date_format:H:i'],
            'breakfast_at'     => ['nullable', 'date_format:H:i'],
        ]);

        $settings = $request->user()->settings ?: $request->user()->settings()->create();
        $settings->fill($data)->save();

        return redirect()->route('monitor.edit');
    }
}
