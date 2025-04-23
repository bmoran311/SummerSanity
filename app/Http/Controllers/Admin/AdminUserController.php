<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admin_users = User::orderBy('name')->get();
        return view('admin.admin_users.list', compact('admin_users'));
    }

    public function create()
    {      
        return view('admin.admin_users.form');
    }

    public function store(Request $request)
    {       
        $request->validate([
            'name' => 'required|string|max:255',           
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:50',           
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin_user = new User();

        if ($request->hasFile('logo')) {                                       
            $path = $request->file('logo')->store('logos', 'public');
            $admin_user->logo = $path;
        }
         
        $admin_user->name = $request->input('name');		
		$admin_user->email = $request->input('email');
		$admin_user->password = Hash::make($request->password);
        $admin_user->save();
        
        return back()->with('success', 'Admin User Created');
    }

    public function edit(User $admin_user)
    {       
        return view('admin.admin_users.form', compact('admin_user'));
    }

    public function update(Request $request, User $admin_user)
    {
        $request->validate([
            'name' => 'required|string|max:255',           
            'email' => 'required|string|max:255',                    
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('remove_logo') && $request->input('remove_logo') == 1) 
        {           
            if ($admin_user->logo) {
                Storage::delete('public/' . $admin_user->logo);
                $admin_user->logo = null; 
            }
        }

        if ($request->hasFile('logo')) {           
            if ($admin_user->logo) {
                Storage::delete($admin_user->logo);
            }
                
            $path = $request->file('logo')->store('logos', 'public');
            $admin_user->logo = $path;
        }

        $admin_user->name = $request->input('name');		
		$admin_user->email = $request->input('email');
        if ($request->filled('password')) 
        {
		    $admin_user->password = $request->input('password');
        }
        $admin_user->save();

        return back()->with('success', 'Admin User Updated');
    }

    public function destroy(User $admin_user)
    {
        $admin_user->delete();

        return back()->with('danger', 'Admin User Deleted');
    }
}