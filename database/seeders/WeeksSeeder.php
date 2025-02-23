<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeeksSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::create(2025, 6, 2); // June 2, 2025 (Monday)
        $weeks = [];

        for ($i = 1; $i <= 12; $i++) {
            $endDate = $startDate->copy()->addDays(4); // Friday of that week

            $weeks[] = [
                'week_number' => $i,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $startDate->addWeek(); // Move to next Monday
        }

        DB::table('week')->insert($weeks);
    }
}
