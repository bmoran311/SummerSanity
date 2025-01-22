<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use Illuminate\Http\Request;
use App\Models\State;
use Carbon\Carbon;

class CampController extends Controller
{
    public function index()
    {    
		$camps = Camp::orderBy('name')->get();
        return view('admin.camps.list', compact('camps'));
    }

    private function updateCampTitle($title, $week)
    {        
        preg_match('/\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2}\s*-\s*\d{1,2}/i', $title, $matches);

        if (!empty($matches)) 
        {
            $originalDateRange = $matches[0]; 
            
            preg_match('/\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2}/i', $originalDateRange, $startDateMatch);

            if (!empty($startDateMatch)) {
                $originalStartDateStr = $startDateMatch[0]; 
                $originalStartDate = Carbon::createFromFormat('F j', $originalStartDateStr);
                
                $newStartDate = $originalStartDate->addDays(7 * $week);
                $newEndDate = $newStartDate->copy()->addDays(3); 
                
                $newDateRange = $newStartDate->format('F j') . '-' . $newEndDate->format('j');
              
                $updatedTitle = str_replace($originalDateRange, $newDateRange, $title);

                return $updatedTitle;
            }
        }

        // Return the original title if no valid date range is found
        return $title;
    }

    public function create()
    {
        $states = State::all();
        $page_title = 'Create Camp';        
        $post_route = route('camp.store');
        $form_method = 'POST';

        return view('admin.camps.form', compact('states', 'page_title', 'post_route', 'form_method'));
    }

    public function store(Request $request)
    {        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (request()->has('clone')) 
        {        		 
            $numberOfWeeks = $request->input('numberOfWeeks', 0);
            
            $startDate = new Carbon($request->input('start_date'));
            $startDay = $startDate->format('d');

            $endDate = new Carbon($request->input('end_date'));
            $endDay = $endDate->format('d');

            $regEndDate = new Carbon($request->input('registration_end_date'));
            $earlyBirdEndDate = new Carbon($request->input('early_bird_price_end_date'));           

            $dayDifference = $startDate->diffInDays($endDate);

            for ($week = 1; $week <= $numberOfWeeks; $week++) 
            {
                $newStartDate = $startDate->copy()->addWeeks($week);
                $newEndDate = $newStartDate->copy()->addDays($dayDifference);
                $newRegistrationEndDate = $regEndDate->copy()->addWeeks($week);
                $newEarlyBirdEndDate = $earlyBirdEndDate->copy()->addWeeks($week);

                $camp = new Camp();             
                if($week > 0)     
                {
                    $camp_name = $this->updateCampTitle($request->input('name'), $week);                       
                }             
                else
                {
                    $camp_name = $request->input('name');
                }
                $camp->name = $camp_name; 
                $camp->activity = $request->input('activity');  
                $camp->min_age = $request->input('min_age');  
                $camp->max_age = $request->input('max_age');  
                $camp->registration_link = $request->input('registration_link');  
                $camp->registration_end_date = $newRegistrationEndDate;
                $camp->price = $request->input('price');  
                $camp->early_bird_price = $request->input('early_bird_price'); 
                $camp->early_bird_price_end_date =  $newEarlyBirdEndDate;
                $camp->start_date = $newStartDate;
                $camp->end_date = $newEndDate;
                $camp->shift = $request->input('shift'); 
                $camp->start_time = $request->input('start_time'); 
                $camp->end_time = $request->input('end_time'); 
                $camp->location = $request->input('location'); 
                $camp->location_address = $request->input('location_address'); 
                $camp->location_city = $request->input('location_city'); 
                $camp->location_state = $request->input('location_state'); 
                $camp->location_zip = $request->input('location_zip'); 
                $camp->capacity = $request->input('capacity'); 		
                $camp->description = $request->input('description');          
                $camp->save();                     
            }            
        }
        else
        {
            $camp->name = $request->input('name'); 
            $camp->activity = $request->input('activity');  
            $camp->min_age = $request->input('min_age');  
            $camp->max_age = $request->input('max_age');  
            $camp->registration_link = $request->input('registration_link');  
            $camp->registration_end_date = $request->input('registration_end_date');
            $camp->price = $request->input('price');  
            $camp->early_bird_price = $request->input('early_bird_price'); 
            $camp->early_bird_price_end_date =  $request->input('early_bird_price_end_date');
            $camp->start_date = $request->input('start_date');
            $camp->end_date = $request->input('end_date');
            $camp->shift = $request->input('shift'); 
            $camp->start_time = $request->input('start_time'); 
            $camp->end_time = $request->input('end_time'); 
            $camp->location = $request->input('location'); 
            $camp->location_address = $request->input('location_address'); 
            $camp->location_city = $request->input('location_city'); 
            $camp->location_state = $request->input('location_state'); 
            $camp->location_zip = $request->input('location_zip'); 
            $camp->capacity = $request->input('capacity'); 		
            $camp->description = $request->input('description');          
            $camp->save();           
        }
          
        return back()->with('success', 'Camp Created');
    }
   
    public function edit(Camp $camp, Request $request)
    {
        if (request()->has('clone')) 
        {
            $page_title = 'Clone Camp';
            $post_route = route('camp.store');  
            $form_method = 'POST';        
        }
        else
        {
            $page_title = 'Edit Camp';
            $post_route = route('camp.update', $camp->id);  
            $form_method = 'PUT';          
        }

        $states = State::all();

        return view('admin.camps.form', compact('camp', 'states', 'page_title', 'post_route', 'form_method'));
    }

    public function update(Request $request, Camp $camp)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $camp->name = $request->input('name');   
		$camp->activity = $request->input('activity');  
		$camp->min_age = $request->input('min_age');  
		$camp->max_age = $request->input('max_age');  
		$camp->registration_link = $request->input('registration_link');  
		$camp->registration_end_date = $request->input('registration_end_date');  
		$camp->price = $request->input('price');  
		$camp->early_bird_price = $request->input('early_bird_price'); 
		$camp->early_bird_price_end_date = $request->input('early_bird_price_end_date'); 
		$camp->start_date = $request->input('start_date'); 
		$camp->end_date = $request->input('end_date'); 
		$camp->shift = $request->input('shift'); 
		$camp->start_time = $request->input('start_time'); 
		$camp->end_time = $request->input('end_time'); 
        $camp->location = $request->input('location');
		$camp->location_address = $request->input('location_address'); 
		$camp->location_city = $request->input('location_city'); 
		$camp->location_state = $request->input('location_state'); 
		$camp->location_zip = $request->input('location_zip'); 
		$camp->capacity = $request->input('capacity'); 		
        $camp->description = $request->input('description');        
        $camp->save();

        return back()->with('success', 'Camp Updated');
    }
    
    public function destroy(Camp $camp)
    {
        $camp->delete();

        return back()->with('danger', 'Camp Deleted');
    }
}
