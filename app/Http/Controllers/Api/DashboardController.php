<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodGlucoseReading;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $latest = BloodGlucoseReading::where('user_id', $userId)
            ->latest('reading_time')
            ->first();

        $latestList = BloodGlucoseReading::where('user_id', $userId)
            ->orderByDesc('reading_time')
            ->take(10)
            ->get();

        $startDate = Carbon::now()->subDays(90);

        $readings = BloodGlucoseReading::where('user_id', $userId)
            ->where('reading_time', '>=', $startDate)
            ->get();

        $summary = [
            'low' => 0,
            'normal' => 0,
            'high' => 0,
        ];

        foreach ($readings as $r) {
            if ($r->blood_glucose < 70) {
                $summary['low']++;
            } elseif ($r->blood_glucose > 130) {
                $summary['high']++;
            } else {
                $summary['normal']++;
            }
        }

        $avgAll = round($readings->avg('blood_glucose'), 1);
        $avgFPG = round($readings->where('context', 'before_breakfast')->avg('blood_glucose'), 1);
        $avgPP2 = round($readings->where('context', 'after_breakfast')->avg('blood_glucose'), 1);

        $status = $this->getStatus($avgFPG, $avgPP2);

        return response()->json([
            'message' => 'Data Dashboard Berhasil diambil',
            'latest' => $latest,
            'summary_90_days' => $summary,
            'average_90_days' => [
                'all' => $avgAll,
                'fasting' => $avgFPG,
                'post_meal' => $avgPP2,
                'status' => $status,
            ],
            'latest_list' => $latestList,
        ]);
    }

    private function getStatus($fpg, $pp2): string
    {
        if (is_null($fpg) && is_null($pp2)) {
            return 'Unknown';
        }

        $isPrediabetes = false;
        $isDiabetes = false;

        if ($fpg >= 100 && $fpg <= 125) $isPrediabetes = true;
        if ($pp2 >= 140 && $pp2 <= 199) $isPrediabetes = true;

        if ($fpg > 125 || $pp2 > 199) $isDiabetes = true;

        if ($isDiabetes) return 'Diabetes';
        if ($isPrediabetes) return 'Prediabetes';
        return 'Normal';
    }
}
