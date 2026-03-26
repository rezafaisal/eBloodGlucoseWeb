<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeightReading;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WeightReadingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight' => ['required', 'numeric', 'between:20,200'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $reading = WeightReading::create([
            'user_id' => $request->user()->id,
            'weight' => $validated['weight'],
            'recorded_at' => $validated['recorded_at'] ?? now(),
        ]);

        return response()->json([
            'message' => 'Weight reading saved',
            'data' => [
                'id' => $reading->id,
                'weight' => (float)$reading->weight,
                'recorded_at' => $reading->recorded_at->toIso8601String(),
                'source' => $reading->source,
                'note' => $reading->note,
            ],
        ], 201);
    }

    public function weightHistory(Request $request)
    {
        $validated = $request->validate([
            'month' => ['required','date_format:Y-m'],
        ]);

        $user = $request->user();

        $start = Carbon::createFromFormat('Y-m', $validated['month'])->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $readings = WeightReading::where('user_id', $user->id)
            ->whereBetween('recorded_at', [$start, $end])
            ->get(['weight', 'recorded_at']);

        $byDay = $readings->groupBy(function ($r) {
            return $r->recorded_at->toDateString();
        })
            ->map(function ($group) {
                return round($group->avg('weight'), 2);
            });

        $data = [];
        foreach ($byDay as $date => $avg) {
            $dayNum = (int) Carbon::parse($date)->format('j');
            $data[] = [
                'day'    => $dayNum,
                'weight' => (float) $avg,
            ];
        }

        $weightChange = null;
        if (count($data) > 1) {
            $earliest = $data[0]['weight'];
            $latest   = $data[count($data)-1]['weight'];
            $weightChange = (string) round($latest - $earliest, 2);
        }

        return response()->json([
            'month'        => $start->format('Y-m'),
            'weightChange' => $weightChange,
            'data'         => $data,
        ]);
    }

}
