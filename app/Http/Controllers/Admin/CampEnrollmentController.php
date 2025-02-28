<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampEnrollment;
use App\Models\Camper;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampEnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = CampEnrollment::orderBy('week_id')->orderBy('created_at')->get();

        return view('admin.camp_enrollment.list', compact('enrollments'));
    }

    public function create(Request $request)
    {
        $selected_guardian_id = $request->input('guardian_id');

        $selectedCamperId = $request->input('camper_id');
        $selected_camper_ids = $selectedCamperId ? (array) $selectedCamperId : [];

        $selectedTimeSlot = $request->input('time_slot');
        $selected_time_slots = $selectedTimeSlot ? (array) $selectedTimeSlot : [];

        $selectedWeek = $request->input('week');
        $selected_week_ids = $selectedWeek ? (array) $selectedWeek : [];

        $campers = Camper::where('guardian_id', $selected_guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $weeks = Week::orderBy('week_number')->get();

        $camp_names = DB::select("
            SELECT
                distinct camp_name AS camp_fill,
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
        ", [$selected_guardian_id, $selected_guardian_id, $selected_guardian_id]);

        return view('admin.camp_enrollment.form', compact('campers', 'weeks', 'camp_names', 'selected_guardian_id', 'selected_camper_ids', 'selected_time_slots', 'selected_week_ids'));
    }

    public function store(Request $request)
    {
        /*$request->validate([
            'camper_id' => 'required|exists:camper,id',
            'week_id' => 'required|exists:week,id',
            'camp_name' => 'required|string|max:255',
            'time_slot' => 'required|in:AM,PM,Night',
        ]);   */

        $enrollments = [];
        $group_id = Str::uuid();

        foreach ($request->input('camper_id') as $camperId) {
            foreach ($request->input('week_id') as $weekId) {
                foreach ($request->input('time_slot') as $timeSlot) {
                    $enrollments[] = [
                        'camper_id' => $camperId,
                        'week_id' => $weekId,
                        'group_id' => $group_id,
                        'camp_name' => $request->input('camp_name'),
                        'time_slot' => $timeSlot,
                        'booked' => $request->input('booked'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        CampEnrollment::insert($enrollments);

        return redirect()->route('calendar.index', ['guardian_id' => $request->guardian_id])->with('success', 'Camp Enrollment successfully added!');
    }

    public function edit(CampEnrollment $camp_enrollment)
    {
        $camper = Camper::find($camp_enrollment->camper_id);
        $selected_guardian_id = $camper->guardian_id;

        $camp_enrollments = CampEnrollment::where('group_id', $camp_enrollment->group_id)->get();

        $selected_camper_ids = $camp_enrollments->pluck('camper_id')->toArray();
        $selected_week_ids = $camp_enrollments->pluck('week_id')->toArray();
        $selected_time_slots = $camp_enrollments->pluck('time_slot')->toArray();

        $campers = Camper::where('guardian_id', $selected_guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $weeks = Week::orderBy('week_number')->get();

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
        ", [$selected_guardian_id, $selected_guardian_id, $selected_guardian_id]);

        return view('admin.camp_enrollment.form', compact('camp_enrollment', 'campers', 'weeks', 'camp_names', 'selected_guardian_id', 'selected_camper_ids', 'selected_week_ids', 'selected_time_slots'));
    }


    public function update(Request $request, CampEnrollment $camp_enrollment)
    {
        $group_id = $camp_enrollment->group_id;
        CampEnrollment::where('group_id', $group_id)->delete();

        $enrollments = [];
            foreach ($request->input('camper_id') as $camperId) {
                foreach ($request->input('week_id') as $weekId) {
                    foreach ($request->input('time_slot') as $timeSlot) {
                        $enrollments[] = [
                            'group_id' => $group_id,
                            'camper_id' => $camperId,
                            'week_id' => $weekId,
                            'camp_name' => $request->input('camp_name'),
                            'time_slot' => $timeSlot,
                            'booked' => $request->input('booked'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

        CampEnrollment::upsert(
                $enrollments,
                ['camper_id', 'week_id', 'time_slot'], // Keys to check for duplicates
                ['camp_name', 'booked', 'updated_at'] // Fields to update if a duplicate exists
            );

            return redirect()->route('calendar.index', ['guardian_id' => $request->guardian_id])->with('success', 'Camp Enrollment successfully Updated');
    }

    public function destroy($group_id)
    {
        $first_enrollment = CampEnrollment::where('group_id', $group_id)->first();
        $camper = Camper::find($first_enrollment->camper_id);
        $guardian_id = $camper->guardian_id;

        CampEnrollment::where('group_id', $group_id)->delete();

        return redirect()->route('calendar.index', ['guardian_id' => $guardian_id])->with('success', 'Camp Enrollment successfully Updated');
    }
}
