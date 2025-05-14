@extends('layouts.dashboard')

@section('content')
    <div class="md:flex md:items-center">
        <div class="filter__friends">
            @foreach($friends_campers as $friends_camper)
                <label>
                    <input type="checkbox" class="friend-child-checkbox" id="friend{{ $loop->iteration }}" checked />
                    {{ $friends_camper->first_name }} {{ $friends_camper->last_name }}
                </label>
            @endforeach
        </div>
        <div class="flex items-center space-x-4 px-8 md:px-0" style="margin-right: 75px; min-width: 375px;">
            <span class="text-2xl shrink-0">Summer Calendar</span>
            <div class="event-card user-child confirmed">
                <div class="card__content" style="text-align: center;">
                    <span class="event-name">Booked</span>
                </div>
            </div>
            <div class="event-card user-child tentative">
                <div class="card__content" style="text-align: center;">
                    <span class="event-name">Tentative</span>
                </div>
            </div>
        </div>
    </div>

    <div id="summer-calendar"></div>

	@include('partials.create_enrollment_modal')
    @include('partials.build_calendar')
@endsection