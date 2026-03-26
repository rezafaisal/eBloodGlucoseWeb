<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBloodGlucoseRequest;
use App\Models\BloodGlucoseReading;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BloodGlucoseController extends Controller
{
    public function index(): JsonResponse
    {
        $blood_glucose = BloodGlucoseReading::where('user_id' , Auth::id())->latest('reading_time')->first();

        return response()
            ->json([
                'message' => 'Fetch Gula Darah Berhasil',
                'blood_glucose' => $blood_glucose
            ]);
    }

    public function listReadings(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 5);

        $blood_glucose = BloodGlucoseReading::where('user_id', Auth::id())
            ->latest('reading_time')
            ->take($limit)
            ->get();

        return response()->json([
            'message' => 'Fetch List Gula Darah Berhasil',
            'blood_glucose' => $blood_glucose
        ]);
    }

    public function store(StoreBloodGlucoseRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $reading = BloodGlucoseReading::create([
            'user_id'            => $user->id,
            'blood_glucose'      => $data['blood_glucose'],
            'context'            => $data['context'] ?? null,
            'reading_time'       => $data['reading_time'],
        ]);

        return response()->json([
            'message' => 'Pencatatan Gula Darah tersimpan',
            'data' => [
                'id'                => $reading->id,
                'blood_glucose'     => $reading->blood_glucose,
                'context'           => $reading->context,
                'reading_time'      => $reading->reading_time,
                'created_at'        => $reading->created_at,
            ],
        ], 201);
    }


    public function bloodGlucoseHistory(Request $request): JsonResponse
    {
        $monthStr = $request->query('month');
        if ($monthStr && !preg_match('/^\d{4}-\d{2}$/', $monthStr)) {
            return response()->json(['message' => 'Parameter month harus format YYYY-MM'], 422);
        }

        $anchor = $monthStr
            ? Carbon::createFromFormat('Y-m', $monthStr)->startOfMonth()
            : now()->startOfMonth();

        $start = $anchor->copy()->startOfMonth();
        $end   = $anchor->copy()->endOfMonth()->endOfDay();

        $readings = BloodGlucoseReading::where('user_id', Auth::id())
            ->whereBetween('reading_time', [$start, $end])
            ->orderBy('reading_time', 'asc')
            ->get(['blood_glucose', 'reading_time']);

        $grouped = [];
        foreach ($readings as $r) {
            $day = Carbon::parse($r->reading_time)->toDateString();
            $val = (float) $r->blood_glucose;
            if (!isset($grouped[$day])) {
                $grouped[$day] = ['sum' => 0.0, 'count' => 0, 'min' => $val, 'max' => $val];
            }
            $grouped[$day]['sum']   += $val;
            $grouped[$day]['count'] += 1;
            $grouped[$day]['min']    = min($grouped[$day]['min'], $val);
            $grouped[$day]['max']    = max($grouped[$day]['max'], $val);
        }

        ksort($grouped);
        $days = [];
        foreach ($grouped as $day => $agg) {
            $avg = $agg['count'] ? round($agg['sum'] / $agg['count'], 1) : null;
            $days[] = [
                'date'  => $day,
                'avg'   => $avg,
                'min'   => $agg['min'],
                'max'   => $agg['max'],
                'count' => $agg['count'],
            ];
        }

        return response()->json([
            'message' => 'Fetch History Gula Darah (rata-rata harian) berhasil',
            'month'   => $anchor->format('Y-m'),
            'data'    => $days,
        ]);
    }
}
