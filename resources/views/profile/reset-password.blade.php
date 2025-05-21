@extends('layouts.dashboard-not-logged-in')

@section('content')
<div class="container campers-page-container">
    <div class="camper-header">
        <h2 style="font-size: 2.75rem;">Reset Your Password</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="lg:col-span-2">
            <form action="{{ route('guardian.password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
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
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
