@extends('layouts.dashboard')

@section('content')
<div class="container campers-page-container">
    <div class="camper-header">
        <h2 style="font-size: 2.75rem;">Your Friends</h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @include('dashboard.friends._list')
        </div>
            <div class="lg:col-span-1">
            @include('dashboard.friends._form')
        </div>
    </div>
    <br><br><br><br>
    <div class="camper-header">
        <h2 style="font-size: 2.75rem;">Friend Requests</h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @include('dashboard.friends._friend_requests')
        </div>            
    </div>
</div>
@endsection

