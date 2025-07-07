<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalariesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all users except admin (id=1)
        $users = User::where('id', '>', 1)->get();

        foreach ($users as $user) {
            DB::table('salaries')->insert([
                'user_id' => $user->id,
                'salary' => rand(30000, 80000),  // random salary amount
                'from' => Carbon::now()->subYear()->format('Y-m-d'), // 1 year ago
                'to' => null,
                'is_active' => 1,
                'is_upgraded' => 1,
                'created_by' => 1,  // Admin user
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
