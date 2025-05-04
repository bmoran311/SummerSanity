<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guardian;
use App\Models\Friend;
use App\Models\Invitation;

class AuthController extends Controller
{
    public function loginWithEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);        

        $credentials = $request->only('email', 'password');      

        if (Auth::guard('guardian')->attempt($credentials)) {
            $request->session()->regenerate();            

            return redirect()->intended('/my-dashboard/');
        }        
          
        return redirect('/#login')->withErrors([            
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registerWithEmail(Request $request)
    {                              
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:guardian,email',
            'phone_number' => 'required|string|max:255',
            'zip_code' => 'required|string|max:50',
            'communication_preference' => 'required|string|max:50',
            'password' => 'required|string|confirmed|max:50',
        ]);
        
        $guardian = new Guardian();
        $guardian->first_name = $request->input('first_name');
        $guardian->last_name = $request->input('last_name');
        $guardian->email = $request->input('email');
        $guardian->phone_number = $request->input('phone_number');
        $guardian->password = Hash::make($request->input('password'));
        $guardian->zip_code = $request->input('zip_code');
        $guardian->communication_preference = $request->input('communication_preference');
        $guardian->active = '1';
        $guardian->save();      

        if ($request->filled('inviter_id')) 
        {         
            Friend::create([
                'guardian_id1' => $request->input('inviter_id'),
                'guardian_id2' => $guardian->id,
            ]);
        }
        
        $invitation = Invitation::where('email', $guardian->email)->first();
        if ($invitation) 
        {
            $invitation->status = 'accepted';
            $invitation->save();
        }

        Auth::guard('guardian')->login($guardian);

        return redirect('/my-dashboard/');     
    }

    public function logout(Request $request)
    {
        Auth::guard('guardian')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
