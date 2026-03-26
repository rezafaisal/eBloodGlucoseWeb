<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class BloodGlucoseReadingSeeder extends Seeder
{
    public function run()
    {
        $demoUser = User::factory()->create([
            'name' => 'Zubairi',
            'email' => 'zubairi@example.com',
            'age' => 25,
            'gender' => 'Male',
            'blood_type' => 'A',
            'height' => 175.5,
            'weight' => 70.5,
        ]);
        $demoUser->assignRole(Role::findById(2));

        $userId = $demoUser->id;
        $numberOfReadings = 50;
        $startDate = Carbon::now()->subDays(2);
        $endDate = Carbon::now();

        for ($i = 0; $i < $numberOfReadings; $i++) {
            $readingTime = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            $blood_glucose = rand(70, 200);

            DB::table('blood_glucose_readings')->insert([
                'user_id' => $userId,
                'blood_glucose' => $blood_glucose,
                'reading_time' => $readingTime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $demoUser2 = User::factory()->create([
            'name' => 'Yahya',
            'email' => 'yahya@example.com',
            'age' => 26,
            'gender' => 'Male',
            'blood_type' => 'B',
            'height' => 168.2,
            'weight' => 65.3,
        ]);
        $demoUser2->assignRole(Role::findById(2));

        $userId2 = $demoUser2->id;
        for ($i = 0; $i < $numberOfReadings; $i++) {
            $readingTime = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            $blood_glucose = rand(70, 200);

            DB::table('blood_glucose_readings')->insert([
                'user_id' => $userId2,
                'blood_glucose' => $blood_glucose,
                'reading_time' => $readingTime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $demoUser3 = User::factory()->create([
            'name' => 'Zain',
            'email' => 'zain@example.com',
            'age' => 28,
            'gender' => 'Male',
            'blood_type' => 'AB',
            'height' => 180.3,
            'weight' => 80.0,
        ]);
        $demoUser3->assignRole(Role::findById(2));

        $userId3 = $demoUser3->id;
        for ($i = 0; $i < $numberOfReadings; $i++) {
            $readingTime = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            $blood_glucose = rand(70, 200);

            DB::table('blood_glucose_readings')->insert([
                'user_id' => $userId3,
                'blood_glucose' => $blood_glucose,
                'reading_time' => $readingTime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
