<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- "Overpass" Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/style.css" />
        <link rel="stylesheet" href="/calendar.css" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/weekSelect/weekSelect.js"></script> --}}

        <title>Dashboard - Summer Sanity</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <div class="dashboard">
            <nav class="nav nav--dashboard">
                <div class="logo">
                    <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
                </div>
				<ul class="nav__links">
					<li class="nav__link"><a href="/my-dashboard">Dashboard</a></li>
					<li class="nav__link"><a href="/campers">Campers</a></li>
					<li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>
				</ul>
				<div class="profile">
					<img src="/assets/megan-p-profile-pic.jpg" alt="User Profile Picture" />
					<span>{{ Auth::guard('guardian')->user()->first_name }} {{ Auth::guard('guardian')->user()->last_name }}</span>
				</div>
            </nav>
            <div class="container campers-page-container">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 15px; background-color: #e6ffed; color: #05603a; padding: 12px 16px; border-radius: 6px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('danger'))
                    <div class="alert alert-danger" style="margin-bottom: 15px; background-color: #e6ffed; color: #05603a; padding: 12px 16px; border-radius: 6px;">
                        {{ session('danger') }}
                    </div>
                @endif


            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    {{ isset($camp_enrollment) ? 'Edit Plan' : 'Add Plan' }}
                </h2>
            </div>

            <form method="POST" action="{{ route('camp_enrollment_fe.destroy', $camp_enrollment->group_id) }}" onsubmit="return confirm('This will delete the entire plan batch. Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700">
                    Delete Plan Batch
                </button>
            </form>
            <br><br>

            <div class="rounded-lg border border-stroke bg-white p-6 shadow-lg dark:border-strokedark dark:bg-boxdark">
                <form method="POST" action="{{ route('calendar.update_enrollment', $camp_enrollment->id) }}">
                    @csrf
                    @if(isset($camp_enrollment))
                        @method('PUT')
                    @endif
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="camper_id" class="block text-2xl font-medium text-gray-700">Camper</label>
                            <select multiple name="camper_id[]" id="camper_id" required class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                @foreach($campers as $camper)
                                    <option value="{{ $camper->id }}"
                                        {{ in_array($camper->id, $selected_camper_ids) ? 'selected' : '' }}>
                                        {{ $camper->first_name }} {{ $camper->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="week_id" class="block text-2xl font-medium text-gray-700">Week</label>
                            <select multiple name="week_id[]" id="week_id" required class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                @foreach($weeks as $week)
                                    <option value="{{ $week->id }}"
                                        {{ in_array($week->id, $selected_week_ids) ? 'selected' : '' }}>
                                        Week {{ $week->week_number }} ({{ \Carbon\Carbon::parse($week->start_date)->format('n/j') }} - {{ \Carbon\Carbon::parse($week->end_date)->format('n/j') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="camp_name" class="block text-2xl font-medium text-gray-700">Camp Name</label>
                            <input type="text" name="camp_name" required id="camp_input"
                                value="{{ old('camp_name', isset($camp_enrollment) ? $camp_enrollment->camp_name : '') }}"
                                class="w-full rounded-md border border-gray-300 p-2 text-xl"
                                list="camp_name_list" >
                        </div>
                        <datalist id="camp_name_list">
                            @foreach($camp_names as $camp)
                                <option value="{{ $camp->camp_fill }}" data-camp-name="{{ $camp->camp_name }}"></option>
                            @endforeach
                        </datalist>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let campInput = document.getElementById("camp_input");

                                campInput.addEventListener("input", function () {
                                    let datalistOptions = document.querySelectorAll("#camp_name_list option");

                                    datalistOptions.forEach(option => {
                                        if (option.value === campInput.value) {
                                            // Set the input field to just the camp_name
                                            campInput.value = option.getAttribute("data-camp-name");
                                        }
                                    });
                                });
                            });
                        </script>
                        <div>
                            <label for="time_slot" class="block text-2xl font-medium text-gray-700">Time Slot</label>
                            <select multiple name="time_slot[]" id="time_slot" required class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                @foreach(['AM', 'PM', 'Night'] as $slot)
                                    <option value="{{ $slot }}"
                                        {{ in_array($slot, $selected_time_slots) ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="booked" class="block text-2xl font-medium text-gray-700">Booked</label>
                            <select name="booked" id="booked" required class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                <option value=""></option>
                                <option value="1" {{ isset($camp_enrollment) && $camp_enrollment->booked == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ isset($camp_enrollment) && $camp_enrollment->booked == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            <br><br>
                            <label for="type" class="block text-2xl font-medium text-gray-700">Type</label>
                            <select name="type" id="type" required class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                <option value=""></option>
                                <option value="Morning Camp" {{ isset($camp_enrollment) && $camp_enrollment->type == "Morning Camp" ? 'selected' : '' }}>Morning Camp</option>
                                <option value="Afternoon Camp" {{ isset($camp_enrollment) && $camp_enrollment->type == "Afternoon Camp" ? 'selected' : '' }}>Afternoon Camp</option>
                                <option value="All Day Camp" {{ isset($camp_enrollment) && $camp_enrollment->type == "All Day Camp" ? 'selected' : '' }}>All_Day Camp</option>
                                <option value="Night Camp" {{ isset($camp_enrollment) && $camp_enrollment->type == "Night Camp" ? 'selected' : '' }}>Night Camp</option>
                                <option value="Overnight Camp" {{ isset($camp_enrollment) && $camp_enrollment->type == "Overnight Camp" ? 'selected' : '' }}>Overnight Camp</option>
                                <option value="Vacation" {{ isset($camp_enrollment) && $camp_enrollment->type == "Vacation" ? 'selected' : '' }}>Vacation</option>
                                <option value="Babysitter Coverage" {{ isset($camp_enrollment) && $camp_enrollment->type == "Babysitter Coverage" ? 'selected' : '' }}>Babysitter Coverage</option>
                            </select>
                        </div>                          
                        <div>
                            <label for="start_day" class="block text-2xl font-medium text-gray-700">Start Day</label>
                            <select name="start_day" class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                <option value=""></option>
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $dayName = \Carbon\Carbon::create()->startOfWeek()->addDays($i)->format('l'); 
                                    @endphp
                                    <option value="{{ $dayName }}" {{ old('start_day', $camp_enrollment->start_day ?? '') === $dayName ? 'selected' : '' }}>
                                        {{ $dayName }}
                                    </option>
                                @endfor
                            </select>
                            <br><br>
                        
                            <label for="end_day" class="block text-2xl font-medium text-gray-700">End Day</label>
                            <select name="end_day" class="w-full rounded-md border border-gray-300 p-2 text-xl">
                                <option value=""></option>
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $dayName = \Carbon\Carbon::create()->startOfWeek()->addDays($i)->format('l'); 
                                    @endphp
                                    <option value="{{ $dayName }}" {{ old('start_day', $camp_enrollment->end_day ?? '') === $dayName ? 'selected' : '' }}>
                                        {{ $dayName }}
                                    </option>
                                @endfor
                            </select>
                        </div>      
                        <div>
                            <label for="start_time" class="block text-2xl font-medium text-gray-700">Start Time</label>
                            <input type="time" name="start_time" required id="camp_input"
                                value="{{ old('start_time', isset($camp_enrollment) ? $camp_enrollment->start_time : '') }}"
                                class="w-full rounded-md border border-gray-300 p-2 text-xl"
                                 >
                                 <br><br><br>
                        
                            <label for="end_time" class="block text-2xl font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time" required id="camp_input"
                                value="{{ old('end_time', isset($camp_enrollment) ? $camp_enrollment->end_time : '') }}"
                                class="w-full rounded-md border border-gray-300 p-2 text-xl"
                                 >
                        </div>                                          
                    </div>


                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('camp_enrollment.index') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 text-2xl">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 text-2xl">
                            {{ isset($camp_enrollment) ? 'Update' : 'Create' }} Plan
                        </button>
                    </div>
                </form>
            </div>


    </div>
</div>

    </body>
</html>
