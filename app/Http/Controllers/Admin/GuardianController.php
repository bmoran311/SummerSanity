<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian, App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::orderBy('last_name')->orderBy('first_name')->get();
        return view('admin.guardians.list', compact('guardians'));
    }

    public function friends($guardian_id)
    {
        $guardians = Guardian::where('id', '!=', $guardian_id)->orderBy('last_name')->orderBy('first_name')->get();
        $guardian = Guardian::find($guardian_id);

        $friendIds = Friend::where('guardian_id1', $guardian_id)->pluck('guardian_id2')->merge(Friend::where('guardian_id2', $guardian_id)->pluck('guardian_id1') )->unique();

        $guardians->each(function ($guardian) use ($friendIds) {
            $guardian->is_friend = $friendIds->contains($guardian->id);
        });
       
        return view('admin.guardians.friends', compact('guardians', 'guardian'));
    }

    public function assign_friends($guardian_id, Request $request)
    {       
        $selectedUsers = $request->select_user ?? []; 

        Friend::where('guardian_id1', $guardian_id)->orWhere('guardian_id2', $guardian_id)->delete();

        foreach ($selectedUsers as $friend_id) {
            Friend::create([
                'guardian_id1' => $guardian_id,
                'guardian_id2' => $friend_id,
            ]);
        }

        return back()->with('success', 'Friendships Created');
    }

    public function create()
    {       
        return view('admin.guardians.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',                       
        ]);

        $guardian = new Guardian();
        
        $guardian->first_name = $request->input('first_name');		
		$guardian->last_name = $request->input('last_name');
        $guardian->password = "password";
		$guardian->email = $request->input('email');
		$guardian->phone_number = $request->input('phone_number');
        $guardian->save();

        return back()->with('success', 'Guardian Created');
    }

    public function edit(guardian $guardian)
    {        
        return view('admin.guardians.form', compact('guardian') );
    }

    public function update(Request $request, guardian $guardian)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',                      
        ]);        

        $guardian->first_name = $request->input('first_name');		
		$guardian->last_name = $request->input('last_name');
		$guardian->email = $request->input('email');
		$guardian->phone_number = $request->input('phone_number');
        $guardian->save();

        return back()->with('success', 'Guardian Updated');
    }

    public function destroy(guardian $guardian)
    {
        $guardian->delete();

         return back()->with('danger', 'Guardian Deleted');
    }
}