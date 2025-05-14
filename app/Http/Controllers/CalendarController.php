<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guardian, App\Models\Camper, App\Models\Friend, App\Models\Week, App\Models\CampEnrollment, App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CalendarInvite;
use App\Mail\FriendRequest;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function dashboard(Request $request)
    {
        $guardian_id = Auth::guard('guardian')->user()->id;

        $campers = Camper::where('guardian_id', $guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $guardian = Guardian::find( $guardian_id );
        $time_slots = "AM,PM,Night";
        $time_slots = explode(',', $time_slots);
        $weeks = Week::orderBy('week_number')->get();

        $friends = Guardian::whereIn('id', function ($query) use ($guardian_id) {
            $query->select('guardian_id2')
                  ->from('friends')
                  ->where('guardian_id1', $guardian_id);
        })->orWhereIn('id', function ($query) use ($guardian_id) {
            $query->select('guardian_id1')
                  ->from('friends')
                  ->where('guardian_id2', $guardian_id);
        })->get();

        $friend_guardian_ids = $friends->pluck('id');

        $friends_campers = Camper::whereIn('guardian_id', $friend_guardian_ids)->orderBy('last_name')->get();

        $camp_enrollment_array = [];
        $camp_enrollment_group_id_array = [];
        $camp_enrollment_type_array = [];
        $camp_enrollment_id_array = [];
        $camp_enrollment_color_array = [];

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
                    $camp_enrollment_group_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->group_id : "";
                    $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->id : "";
                    $camp_enrollment_type_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->type : "";
                    $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] =
                        ($enrollment && $enrollment->booked) ? "yellow" :
                        (($enrollment && $enrollment->camp_name) ? "#F8E5A6" : "");
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
                    $camp_enrollment_group_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->group_id : "";
                    $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->id : "";
                    $camp_enrollment_type_array[$camper->id][$time_slot][$week->week_number] = $enrollment ? $enrollment->type : "";
                    $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] =
                        ($enrollment && $enrollment->booked) ? "yellow" :
                        (($enrollment && $enrollment->camp_name) ? "#F8E5A6" : "");
                }
            }
        }

        $guardianId = Auth::guard('guardian')->id();

        $friends = Guardian::whereIn('id', function($query) use ($guardianId) {
            $query->select(DB::raw('CASE
                WHEN guardian_id1 = '.$guardianId.' THEN guardian_id2
                WHEN guardian_id2 = '.$guardianId.' THEN guardian_id1
            END'))
            ->from('friends')
            ->whereRaw('guardian_id1 = '.$guardianId.' OR guardian_id2 = '.$guardianId);
        })->select('first_name', 'last_name', 'email')->get();

        $pending_invitations = Invitation::where('guardian_id', Auth::guard('guardian')->id())->where('status', 'pending')->get();

        return view('dashboard.index', compact( 'campers',
                                                'camp_names',
                                                'time_slots',
                                                'guardian',
                                                'friends',
                                                'friends_campers',
                                                'weeks',
                                                'pending_invitations',
                                                'camp_enrollment_id_array',
                                                'camp_enrollment_type_array',
                                                'camp_enrollment_array',
                                                'camp_enrollment_group_id_array',
                                                'camp_enrollment_color_array')
                                            );
    }

    public function edit_enrollment($id)
    {       
        $camp_enrollment = CampEnrollment::findOrFail($id);
        if ($camp_enrollment->camper->guardian_id !== Auth::guard('guardian')->id()) {
            abort(403);
        }

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

        return view('dashboard.enrollment.edit', compact('camp_enrollment', 'campers', 'weeks', 'camp_names', 'selected_guardian_id', 'selected_camper_ids', 'selected_week_ids', 'selected_time_slots'));
    }

    public function update_enrollment(Request $request, $id)
    {       
        $camp_enrollment = CampEnrollment::findOrFail($id);
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
                            'type' => $request->input('type'),
                            'start_day' => $request->input('start_day'),
                            'end_day' => $request->input('end_day'),
                            'start_time' => $request->input('start_time'),
                            'end_time' => $request->input('end_time'),
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

        return redirect()->route('dashboard.index' )->with('success', 'Plan successfully Updated');
    }

    public function delete_enrollment($group_id)
    {
        $first_enrollment = CampEnrollment::where('group_id', $group_id)->first();
        $camper = Camper::find($first_enrollment->camper_id);
        $guardian_id = $camper->guardian_id;

        CampEnrollment::where('group_id', $group_id)->delete();

        return redirect()->route('dashboard.index')->with('success', 'Plan Batch successfully deleted');
    }

    public function campers(Request $request)
    {
        $guardian_id = Auth::guard('guardian')->user()->id;

        $friends = Guardian::whereIn('id', function ($query) use ($guardian_id) {
            $query->select('guardian_id2')
                  ->from('friends')
                  ->where('guardian_id1', $guardian_id);
        })->orWhereIn('id', function ($query) use ($guardian_id) {
            $query->select('guardian_id1')
                  ->from('friends')
                  ->where('guardian_id2', $guardian_id);
        })->get();

        $pending_invitations = Invitation::where('guardian_id', Auth::guard('guardian')->id())->where('status', 'pending')->get();

        $campers = Camper::where('guardian_id', $guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $guardian = Guardian::find( $guardian_id );

        return view('dashboard.campers.index', compact( 'campers', 'friends', 'pending_invitations', 'guardian_id') );
    }

    public function friends(Request $request)
    {
        $guardian_id = Auth::guard('guardian')->user()->id;
        
        $friendIds = Friend::where('guardian_id1', $guardian_id)
            ->pluck('guardian_id2')
            ->merge(Friend::where('guardian_id2', $guardian_id)->pluck('guardian_id1'))
            ->unique();

       
        $friends = Guardian::whereIn('id', $friendIds)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
            
        $pending_invitations = Invitation::where('guardian_id', Auth::guard('guardian')->id())->where('status', 'pending')->get();
            
        $searchResults = collect();
        if ($request->filled('first_name') || $request->filled('last_name')) {
            $searchResults = Guardian::where('id', '!=', $guardian_id)
                ->whereNotIn('id', $friendIds)
                ->when($request->first_name, fn($q) => $q->where('first_name', 'LIKE', '%' . $request->first_name . '%'))
                ->when($request->last_name, fn($q) => $q->where('last_name', 'LIKE', '%' . $request->last_name . '%'))
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();            
        }

        return view('dashboard.friends.index', compact( 'friends', 'pending_invitations', 'guardian_id', 'searchResults') );
    }

    public function edit_camper(Request $request, Camper $camper)
    {
        $guardian_id = Auth::guard('guardian')->user()->id;
        if ($camper->guardian_id !== Auth::guard('guardian')->id()) {
            abort(403);
        }

        $c = $camper;

        $campers = Camper::where('guardian_id', $guardian_id )->orderBy('last_name')->orderBy('first_name')->get();
        $guardian = Guardian::find( $guardian_id );

        $friendIds = Friend::where('guardian_id1', $guardian_id)
            ->pluck('guardian_id2')
            ->merge(Friend::where('guardian_id2', $guardian_id)->pluck('guardian_id1'))
            ->unique();

       
        $friends = Guardian::whereIn('id', $friendIds)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $pending_invitations = Invitation::where('guardian_id', Auth::guard('guardian')->id())->where('status', 'pending')->get();

        return view('dashboard.campers.index', compact('c', 'guardian_id', 'friends', 'campers', 'pending_invitations'));
    }

    public function create_camper(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',
        ]);

        $camper = new Camper();

        $birth_date = \Carbon\Carbon::createFromFormat('M d, Y', $request->birth_date)->format('Y-m-d');

        $camper->first_name = $request->input('first_name');
        $camper->guardian_id = Auth::guard('guardian')->user()->id;
        $camper->last_name = $request->input('last_name');
        $camper->birth_date = $birth_date;
        $camper->save();

        return back()->with('success', 'Camper Created');
    }

    public function update(Request $request, Camper $camper)
    {
        if ($camper->guardian_id !== Auth::guard('guardian')->id()) {
            abort(403);
        }

        $camper->first_name = $request->input('first_name');
        $camper->birth_date = $request->input('birth_date');
        $camper->save();

        return back()->with('success', 'Camper updated!');
    }

    public function destroy(camper $camper)
    {
        if ($camper->guardian_id !== Auth::guard('guardian')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $camper->delete();

        return back()->with('danger', 'Camper Deleted');
    }

    public function destroy_friendship(Guardian $friend)
    {
        $guardianId = Auth::guard('guardian')->id();

        // Ensure the friendship exists between the two guardians
        $friendship = Friend::where(function ($query) use ($guardianId, $friend) {
            $query->where('guardian_id1', $guardianId)
                ->where('guardian_id2', $friend->id);
        })->orWhere(function ($query) use ($guardianId, $friend) {
            $query->where('guardian_id1', $friend->id)
                ->where('guardian_id2', $guardianId);
        })->first();

        if (!$friendship) {
            abort(404, 'Friendship not found.');
        }

        $friendship->delete();

        return back()->with('success', 'Friend removed from your calendar.');
    }

    public function sendInvites(Request $request)
    {      
        $request->validate([
            'emails' => 'required|string'
        ]);

        $emails = explode(',', $request->emails);        

        foreach ($emails as $email)
        {
            $cleanEmail = trim($email);
            $alreadyInvited = Invitation::where('guardian_id', Auth::guard('guardian')->id())
                                    ->where('email', $cleanEmail)
                                    ->exists();                                   
            if (!$alreadyInvited)
            {                
                Mail::to($cleanEmail)->send(new CalendarInvite(Auth::guard('guardian')->id(), $cleanEmail));

                Invitation::create([
                    'guardian_id' => Auth::guard('guardian')->id(),
                    'email' => $cleanEmail,
                    'status' => 'pending',
                ]);                
            }
        }

        return back()->with('success', 'Invitations sent successfully!');
    }

    public function requestFriendship(Request $request)
    {               
        $fromGuardian = Auth::guard('guardian')->user();
        $toGuardian = Guardian::findOrFail($request->guardian_id);

        // Prevent duplicate requests
        $alreadyRequested = Friend::where(function($query) use ($fromGuardian, $toGuardian) {
            $query->where('guardian_id1', $fromGuardian->id)
                ->where('guardian_id2', $toGuardian->id);
        })->orWhere(function($query) use ($fromGuardian, $toGuardian) {
            $query->where('guardian_id1', $toGuardian->id)
                ->where('guardian_id2', $fromGuardian->id);
        })->exists();

        if ($alreadyRequested) {
            return back()->with('info', 'You’ve already sent or received a friend request with this guardian.');
        }

        // Send the friendship request email
        Mail::to($toGuardian->email)->send(new FriendRequest($fromGuardian, $toGuardian));

        return back()->with('success', 'Friendship request sent!');
    }

    public function accept(Request $request)
    {
        // Validate that this link is signed (handled via middleware in routes)
        $fromId = $request->query('from');
        $toId = $request->query('to');

        $from = Guardian::findOrFail($fromId);
        $to = Guardian::findOrFail($toId);

        // Prevent duplicate friendships
        $alreadyFriends = Friend::where(function($q) use ($fromId, $toId) {
            $q->where('guardian_id1', $fromId)->where('guardian_id2', $toId);
        })->orWhere(function($q) use ($fromId, $toId) {
            $q->where('guardian_id1', $toId)->where('guardian_id2', $fromId);
        })->exists();

        if (! $alreadyFriends) {
            Friend::create([
                'guardian_id1' => $fromId,
                'guardian_id2' => $toId,
            ]);
        }

        // Optional: auto-login the user if not already authenticated
        if (!Auth::guard('guardian')->check()) {
            Auth::guard('guardian')->loginUsingId($toId);
        }

        return redirect()->route('dashboard.index')->with('success', 'Friend request accepted! You’re now connected.');
    }
}
