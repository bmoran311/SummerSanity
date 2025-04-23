<x-app-layout>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        {{ isset($camp_enrollment) ? 'Edit Plan' : 'Add Plan' }}
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>            
            <li class="font-medium text-primary"><a class="font-medium" href="{{ route('camp_enrollment.index') }}">Plans</a></li>         
        </ol>
    </nav>
</div>

@if(isset($camp_enrollment))
    <form method="POST" action="{{ route('camp_enrollment.destroy', $camp_enrollment->group_id) }}" onsubmit="return confirm('Are you sure you want to delete this entire enrollment batch?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700">
            Delete Plan Batch
        </button>
    </form>
    <br><br>
@endif

<div class="rounded-lg border border-stroke bg-white p-6 shadow-lg dark:border-strokedark dark:bg-boxdark">
    <form method="POST" action="{{ isset($camp_enrollment) ? route('camp_enrollment.update', $camp_enrollment) : route('camp_enrollment.store') }}">
        @csrf
        @if(isset($camp_enrollment))
            @method('PUT')
        @endif

        <input type="hidden" name="guardian_id" value="{{$selected_guardian_id}}">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">           
            <div>
                <label for="camper_id" class="block text-sm font-medium text-gray-700">Camper</label>
                <select multiple name="camper_id[]" id="camper_id" required class="w-full rounded-md border border-gray-300 p-2">
                    @foreach($campers as $camper)
                        <option value="{{ $camper->id }}" 
                            {{ in_array($camper->id, $selected_camper_ids) ? 'selected' : '' }}>
                            {{ $camper->first_name }} {{ $camper->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>           
            <div>
                <label for="week_id" class="block text-sm font-medium text-gray-700">Week</label>
                <select multiple name="week_id[]" id="week_id" required class="w-full rounded-md border border-gray-300 p-2">
                    @foreach($weeks as $week)
                        <option value="{{ $week->id }}" 
                            {{ in_array($week->id, $selected_week_ids) ? 'selected' : '' }}>
                            Week {{ $week->week_number }} ({{ \Carbon\Carbon::parse($week->start_date)->format('n/j') }} - {{ \Carbon\Carbon::parse($week->end_date)->format('n/j') }})
                        </option>
                    @endforeach
                </select>
            </div>            
            <div class="col-span-2">
                <label for="camp_name" class="block text-sm font-medium text-gray-700">Camp Name</label>
                <input type="text" name="camp_name" required id="camp_input"
                    value="{{ old('camp_name', isset($camp_enrollment) ? $camp_enrollment->camp_name : '') }}"
                    class="w-full rounded-md border border-gray-300 p-2"
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
                <label for="time_slot" class="block text-sm font-medium text-gray-700">Time Slot</label>
                <select multiple name="time_slot[]" id="time_slot" required class="w-full rounded-md border border-gray-300 p-2">
                    @foreach(['AM', 'PM', 'Night'] as $slot)
                        <option value="{{ $slot }}" 
                            {{ in_array($slot, $selected_time_slots) ? 'selected' : '' }}>
                            {{ $slot }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="booked" class="block text-sm font-medium text-gray-700">Booked</label>
                <select name="booked" id="booked" required class="w-full rounded-md border border-gray-300 p-2">
                    <option value=""></option>
                    <option value="1" {{ isset($camp_enrollment) && $camp_enrollment->booked == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ isset($camp_enrollment) && $camp_enrollment->booked == 0 ? 'selected' : '' }}>No</option>
                </select>
                <br><br>
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" required class="w-full rounded-md border border-gray-300 p-2">
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
        </div>       

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('camp_enrollment.index') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                {{ isset($camp_enrollment) ? 'Update' : 'Create' }} Plan
            </button>
        </div>
    </form>
</div>

</x-app-layout>
