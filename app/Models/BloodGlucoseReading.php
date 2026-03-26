<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BloodGlucoseReading extends Model
{
    protected $fillable = ['user_id', 'blood_glucose', 'context', 'reading_time'];

    protected $appends = ['context_label'];

    protected function contextLabel(): Attribute
    {
        return Attribute::get(function () {
            $map = [
                'before_breakfast' => 'Sebelum Sarapan',
                'after_breakfast'  => 'Sesudah Sarapan',
                'random'           => 'Lainnya',
            ];

            return $map[$this->context] ?? ucfirst($this->context);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
