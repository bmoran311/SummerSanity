<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian, App\Models\Camper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    public function index()
    {
        $campers = Camper::where('guardian_id', request('guardian_id') )->orderBy('last_name')->orderBy('first_name');
        $guardian = Guardian::find(request('guardian_id'));
       
        return view('admin.calendar.index', compact('campers', 'guardian'));
    }
}