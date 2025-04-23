<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guardian;

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

    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:guardians,email',
            'phone_number' => 'required|string|max:255',
            'password'     => 'required|string|min:8|max:50',
        ]);

        $guardian = new Guardian();
        $guardian->first_name = $request->input('first_name');
        $guardian->last_name = $request->input('last_name');
        $guardian->email = $request->input('email');
        $guardian->phone_number = $request->input('phone_number');
        $guardian->password = Hash::make($request->input('password'));

        $guardian->save();

        return back()->with('success', 'Guardian Created');
    }

    public function logout(Request $request)
    {
        Auth::guard('guardian')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
