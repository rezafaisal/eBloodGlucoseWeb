<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'fasting_start_at', 'breakfast_at'
    ];

    protected $casts = [
        'fasting_start_at' => 'datetime:H:i:s',
        'breakfast_at'     => 'datetime:H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
