<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camper, App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CamperController extends Controller
{
    public function index(Request $request)
    {
        $query = Camper::orderBy('last_name')->orderBy('first_name');

        if (request()->has('guardian_id')) {
            $query->where('guardian_id', request('guardian_id'));

            $guardian = Guardian::find(request('guardian_id'));

            $page_name = "Campers for " . $guardian->first_name . " " . $guardian->last_name;
        }
        else
        {
            $page_name = "Campers";
        }

        $campers = $query->get();

        return view('admin.campers.list', compact('campers', 'page_name'));
    }

    public function create()
    {      
        $guardians = Guardian::orderBy('last_name')->orderBy('first_name')->get();
        
        return view('admin.campers.form', compact('guardians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',            
        ]);

        $camper = new Camper();
        
        $camper->first_name = $request->input('first_name');	
        $camper->guardian_id = $request->input('guardian_id');
		$camper->last_name = $request->input('last_name');       
		$camper->birth_date = $request->input('birth_date');		
        $camper->save();

        return back()->with('success', 'Camper Created');
    }

    public function edit(camper $camper)
    {        
        $guardians = Guardian::orderBy('last_name')->orderBy('first_name')->get();

        return view('admin.campers.form', compact('camper', 'guardians') );
    }

    public function update(Request $request, camper $camper)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',           
        ]);
                      
        $camper->first_name = $request->input('first_name');		
		$camper->last_name = $request->input('last_name');
		$camper->birth_date = $request->input('birth_date');	
        $camper->save();

        return back()->with('success', 'Camper Updated');
    }

    public function destroy(camper $camper)
    {
        $camper->delete();

        return back()->with('danger', 'Camper Deleted');
    }
}