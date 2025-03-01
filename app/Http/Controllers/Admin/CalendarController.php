<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian, App\Models\Camper, App\Models\Friend, App\Models\Week, App\Models\CampEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class CalendarController extends Controller
{
    public function index($guardian_id)
    {
        $campers = Camper::where('guardian_id', $guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $guardian = Guardian::find( $guardian_id );
        $time_slots = "AM,PM,Night";
        $time_slots = explode(',', $time_slots);
        $weeks = Week::orderBy('week_number')->get();

        $friends = Guardian::whereIn('id', function ($query) use ($guardian_id) {
            $query->select('guardian_id2')->from('friends')->where('guardian_id1', $guardian_id);
        })->get();

        $friend_guardian_ids = $friends->pluck('id');

        $friends_campers = Camper::whereIn('guardian_id', $friend_guardian_ids)->orderBy('last_name')->get();

        $camp_enrollment_array = [];
        $camp_enrollment_id_array = [];
        $camp_enrollment_color_array = [];

        $camp_names = DB::select("
            SELECT
                CONCAT(camper.first_name, ' ', camper.last_name, ' ', camp_name, ' ', time_slot) AS camp_fill,
                camp_name
            FROM camp_enrollment
            INNER JOIN camper ON camp_enrollment.camper_id = camper.id
            WHERE camper.guardian_id IN (
                SELECT
                    CASE
                        WHEN guardian_id1 = ? THEN guardian_id2
                        ELSE guardian_id1
                    END
                FROM friends
                WHERE guardian_id1 = ? OR guardian_id2 = ?
            )
        ", [$guardian->id, $guardian->id, $guardian->id]);


        foreach($campers as $camper)
        {
            foreach($time_slots as $time_slot)
            {
                foreach($weeks as $week)
                {
                    $enrollment = CampEnrollment::where('camper_id', $camper->id)
                        ->where('week_id', $week->id)
                        ->where('time_slot', $time_slot)
                        ->first();

                    $camp_enrollment_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->camp_name : "";
                    $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->id : "";
                    $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] = ($enrollment && $enrollment->booked) ? "yellow" : "";
                }
            }
        }

        foreach($friends_campers as $camper)
        {
            foreach($time_slots as $time_slot)
            {
                foreach($weeks as $week)
                {
                    $enrollment = CampEnrollment::where('camper_id', $camper->id)
                        ->where('week_id', $week->id)
                        ->where('time_slot', $time_slot)
                        ->first();

                    $camp_enrollment_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->camp_name : "";
                    $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->id : "";
                    $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] = ($enrollment && $enrollment->booked) ? "yellow" : "";
                }
            }
        }

        return view('admin.calendar.index', compact('campers', 'camp_names', 'time_slots', 'guardian', 'friends_campers', 'weeks', 'camp_enrollment_id_array', 'camp_enrollment_array', 'camp_enrollment_color_array'));
    }
}
