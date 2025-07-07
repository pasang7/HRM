<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::create(2025, 6, 1);
        $endDate = Carbon::create(2025, 6, 30);
        $users = User::all();

        foreach ($users as $user) {
            $date = $startDate->copy();

            while ($date->lte($endDate)) {

                // Skip Saturdays only
                if ($date->dayOfWeek === Carbon::SATURDAY) {
                    $date->addDay();
                    continue;
                }

                $isLate = rand(0, 9) === 0 ? 1 : 0; // ~10% chance
                $isAbsent = rand(0, 49) === 0 ? 1 : 0; // ~2% chance
                $isWfh = !$isAbsent && rand(0, 49) === 1 ? 1 : 0; // ~2% chance if not absent

                DB::table('attendances')->insert([
                    'user_id' => $user->id,
                    'shift_id' => 1,
                    'date' => $date->format('Y-m-d'),
                    'remarks' => null,
                    'is_holiday' => 0,
                    'holiday_type' => null,
                    'holiday_id' => null,
                    'is_late' => $isLate,
                    'is_absent' => $isAbsent,
                    'is_wfh' => $isWfh,
                    'is_leave' => 0,
                    'is_travel' => 0,
                    'leave_type_id' => null,
                    'leave_day' => null,
                    'leave_id' => null,
                    'is_paid' => 1,
                    'clockin' => $isAbsent ? null : Carbon::createFromTime(9, $isLate ? rand(15, 59) : rand(0, 10))->format('H:i:s'),
                    'clockout' => $isAbsent ? null : Carbon::createFromTime(17, rand(0, 30))->format('H:i:s'),
                    'clockin_verification' => $isAbsent ? 0 : 1,
                    'clockout_verification' => $isAbsent ? 0 : 1,
                    'actual_time' => $isAbsent ? null : Carbon::createFromTime(9, $isLate ? rand(15, 59) : rand(0, 10))->format('H:i:s'),
                    'reviewed_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $date->addDay();
            }
        }
    }
}
