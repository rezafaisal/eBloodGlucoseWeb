<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightReading extends Model
{
    protected $fillable = ['user_id', 'weight', 'recorded_at'];

    protected $casts = [
        'recorded_at' => 'datetime',
        'weight'   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBetween($query, $start, $end)
    {
        return $query->whereBetween('recorded_at', [$start, $end]);
    }
}
