<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::orderBy('last_name')->orderBy('first_name')->get();
        return view('admin.guardians.list', compact('guardians'));
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