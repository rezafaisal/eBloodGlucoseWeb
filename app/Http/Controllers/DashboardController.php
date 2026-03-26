<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $patients = User::role('user')->with('bloodGlucoseReadings')->get();

        $patientsData = $patients->map(function ($patient) {
            $readings = $patient->bloodGlucoseReadings;

            if ($readings->isEmpty()) {
                return [
                    'name' => $patient->name,
                    'average' => null,
                    'data' => [
                        ['name' => 'Rendah', 'glucose' => 0],
                        ['name' => 'Normal', 'glucose' => 0],
                        ['name' => 'Tinggi', 'glucose' => 0],
                    ],
                ];
            }

            $avg = round($readings->avg('blood_glucose'));

            $low = $readings->where('blood_glucose', '<', 70)->count();
            $normal = $readings->whereBetween('blood_glucose', [70, 140])->count();
            $high = $readings->where('blood_glucose', '>', 140)->count();

            return [
                'name' => $patient->name,
                'average' => $avg,
                'data' => [
                    ['name' => 'Rendah', 'glucose' => $low],
                    ['name' => 'Normal', 'glucose' => $normal],
                    ['name' => 'Tinggi', 'glucose' => $high],
                ],
            ];
        });

        return Inertia::render('Dashboard', [
            'patients' => $patientsData,
        ]);
    }

    public function show(User $user)
    {
        $user->load('latestWeight');

        $readings = $user->bloodGlucoseReadings()->latest()->take(20)->get();

        $avg = round($readings->avg('blood_glucose'));
        $low = $readings->where('blood_glucose', '<', 70)->count();
        $normal = $readings->whereBetween('blood_glucose', [70, 140])->count();
        $high = $readings->where('blood_glucose', '>', 140)->count();

        $dailyReadings = $user->bloodGlucoseReadings()
            ->whereMonth('reading_time', now()->month)
            ->whereYear('reading_time', now()->year)
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->reading_time)->toDateString())
            ->map(fn($group, $date) => [
                'name' => (string) Carbon::parse($date)->day,
                'glucose' => round($group->avg('blood_glucose')),
            ])
            ->values();

        return Inertia::render('Detail', [
            'patient' => $user,
            'summary' => [
                'average' => $avg,
                'low' => $low,
                'normal' => $normal,
                'high' => $high,
                'total' => $readings->count(),
            ],
            'readings' => $readings,
            'dailyReadings' => $dailyReadings,
        ]);
    }

}
