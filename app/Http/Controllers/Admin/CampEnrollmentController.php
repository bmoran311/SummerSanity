<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampEnrollment;
use App\Models\Camper;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampEnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = CampEnrollment::orderBy('week_id')->orderBy('created_at')->get();

        return view('admin.camp_enrollment.list', compact('enrollments'));
    }

    public function create()
    {
        $campers = Camper::orderBy('last_name')->get();
        $weeks = Week::orderBy('week_number')->get();
        $camp_names = CampEnrollment::distinct()->pluck('camp_name');       

        $camp_names = DB::select("
            SELECT 
                CONCAT(camper.first_name, ' ', camper.last_name, ' ', camp_name, ' ', time_slot) AS camp_fill, 
                camp_name
            FROM summer_sanity.camp_enrollment
            INNER JOIN summer_sanity.camper 
                ON camp_enrollment.camper_id = camper.id
        ");        

        return view('admin.camp_enrollment.form', compact('campers', 'weeks', 'camp_names'));
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
        foreach ($request->input('camper_id') as $camperId) {
            foreach ($request->input('week_id') as $weekId) {
                foreach ($request->input('time_slot') as $timeSlot) {
                    $enrollments[] = [
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
       
        CampEnrollment::insert($enrollments);

        return back()->with('success', 'Camp Enrollments Created Successfully');
    }

    public function edit(CampEnrollment $camp_enrollment)
    {
        $campers = Camper::orderBy('last_name')->get();
        $weeks = Week::orderBy('week_number')->get();

        return view('admin.camp_enrollment.form', compact('camp_enrollment', 'campers', 'weeks'));
    }

    public function update(Request $request, CampEnrollment $enrollment)
    {
        /*$request->validate([
            'camper_id'   => 'required|array',
            'camper_id.*' => 'exists:campers,id', 
            'week_id'     => 'required|array',
            'week_id.*'   => 'exists:weeks,id', 
            'camp_name'   => 'required|string|max:255',
            'time_slot'   => 'required|in:AM,PM,Night',
        ]);      */

        $enrollment->camper_id = $request->input('camper_id');
        $enrollment->week_id = $request->input('week_id');
        $enrollment->camp_name = $request->input('camp_name');
        $enrollment->time_slot = $request->input('time_slot');
        $enrollment->booked = $request->input('booked');
        $enrollment->save();

        return back()->with('success', 'Camp Enrollment Updated');
    }

    public function destroy(CampEnrollment $camp_enrollment)
    {
        $camp_enrollment->delete();

        return back()->with('danger', 'Camp Enrollment Deleted');
    }
}
