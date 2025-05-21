@extends('layouts.dashboard')

@section('content')
<div class="container campers-page-container">
    <div class="camper-header">
        <h2 style="font-size: 2.75rem;">Your Profile</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="lg:col-span-2">
            <form action="{{ route('guardian.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label>First Name</x-label>
                            <x-text-input name="first_name" type="text" value="{{ old('first_name', $guardian->first_name) }}" class="text-input" placeholder="First Name..." />
                            <x-form-error key="first_name" />
                        </div>
                        <div>
                            <x-label>Last Name</x-label>
                            <x-text-input name="last_name" type="text" value="{{ old('last_name', $guardian->last_name) }}" class="text-input" placeholder="Last Name..." />
                            <x-form-error key="last_name" />
                        </div>
                        <div>
                            <x-label>Email</x-label>
                            <x-text-input name="email" type="email" value="{{ old('email', $guardian->email) }}" class="text-input" placeholder="Email..." />
                            <x-form-error key="email" />
                        </div>
                        <div>
                            <x-label>Phone Number</x-label>
                            <x-text-input name="phone_number" type="text" value="{{ old('phone_number', $guardian->phone_number) }}" class="text-input" placeholder="Phone Number..." />
                            <x-form-error key="phone_number" />
                        </div>
                        <div>
                            <x-label>Zip Code</x-label>
                            <x-text-input name="zip_code" type="text" value="{{ old('zip_code', $guardian->zip_code) }}" class="text-input" placeholder="Zip Code..." />
                            <x-form-error key="zip_code" />
                        </div>                        
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Change Password (Optional)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label>New Password</x-label>
                            <x-text-input name="password" type="password" class="text-input" placeholder="New Password..." />
                            <x-form-error key="password" />
                        </div>
                        <div>
                            <x-label>Confirm New Password</x-label>
                            <x-text-input name="password_confirmation" type="password" class="text-input" placeholder="Confirm Password..." />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn--md save-btn">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
