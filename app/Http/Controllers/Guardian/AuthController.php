<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guardian;
use App\Models\Friend;
use App\Models\Invitation;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
          
        return redirect('/')->withErrors([            
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
        $guardian->zip_code = $request->input('zip_code');        $guardian->communication_preference = $request->input('communication_preference');
		if ($request->filled('inviter_id')): 		
			$guardian->active = '1';
        else:
			$guardian->active = '0';
		endif;
		
        $guardian->save();      

        if ($request->filled('inviter_id')) 
        {         
            Friend::create([
                'guardian_id1' => $request->input('inviter_id'),
                'guardian_id2' => $guardian->id,
            ]);
			
			$invitation = Invitation::where('email', $guardian->email)->first();
			if ($invitation) 
			{
				$invitation->status = 'accepted';
				$invitation->save();
			}
			
			Auth::guard('guardian')->login($guardian);
			
			return redirect('/my-dashboard/')->with('success', 'Thanks for signing up! Please add your Campers to get started.');  
        }                              
		else
		{		
            $signedUrl = URL::temporarySignedRoute(
                'guardian.confirm',
                now()->addMinutes(60),
                ['guardian' => $guardian->id, 'email' => $request->input('email')]
            );
            
            Mail::to($request->input('email'))->bcc(['hello@summersanity.com', 'bmoran@enertia-inc.com'])->send(new RegistrationConfirmation($request->input('email'), $signedUrl));

            return redirect()->route('home')->with('success', 'Thanks for signing up! Please check your email to confirm your account and get started.');
		}
    }

    public function confirmEmail(Request $request, $id)
    {
        $guardian = Guardian::findOrFail($id);
       
        if (! $request->hasValidSignature()) {
            abort(401, 'Invalid or expired confirmation link.');
        }

        
        $guardian->active = 1;
        $guardian->save();
       
        Auth::guard('guardian')->login($guardian);       

        return redirect('/my-dashboard/')->with('success', 'Account confirmed and you are now logged in! Please add your campers to get started.');
    }

    public function logout(Request $request)
    {
        Auth::guard('guardian')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
	
	public function editProfile(Request $request)
	{			
		$guardian = Auth::guard('guardian')->user();

		$request->validate([
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:guardian,email,' . $guardian->id,
			'phone_number' => 'required|string|max:255',
			'zip_code' => 'required|string|max:50',			
			'password' => 'nullable|string|confirmed|max:50',
		]);

		$guardian->first_name = $request->input('first_name');
		$guardian->last_name = $request->input('last_name');
		$guardian->email = $request->input('email');
		$guardian->phone_number = $request->input('phone_number');
		$guardian->zip_code = $request->input('zip_code');
		$guardian->communication_preference = $request->input('communication_preference');

		if ($request->filled('password')) {
			$guardian->password = Hash::make($request->input('password'));
		}

		$guardian->save();

		return redirect()->route('dashboard.index')->with('success', 'Profile updated successfully!');
	}

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:guardian,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = Password::broker('guardians')->sendResetLink(
            $request->only('email')
        );

        return back()->with('success', 'We emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('profile.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $status = Password::broker('guardians')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($guardian, $password) {
                $guardian->password = Hash::make($password);
                $guardian->setRememberToken(Str::random(60));
                $guardian->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success', 'Your password has been reset!')
            : back()->withErrors(['email' => __($status)]);
    }
}