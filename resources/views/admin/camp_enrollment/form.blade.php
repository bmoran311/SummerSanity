<x-app-layout>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        {{ isset($camp_enrollment) ? 'Edit Camp Enrollment' : 'Add Camp Enrollment' }}
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>            
            <li class="font-medium text-primary"><a class="font-medium" href="{{ route('camp_enrollment.index') }}">Camp Enrollments</a></li>         
        </ol>
    </nav>
</div>

<div class="rounded-lg border border-stroke bg-white p-6 shadow-lg dark:border-strokedark dark:bg-boxdark">
    <form method="POST" action="{{ isset($camp_enrollment) ? route('camp_enrollment.update', $camp_enrollment) : route('camp_enrollment.store') }}">
        @csrf
        @if(isset($camp_enrollment))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">           
            <div>
                <label for="camper_id" class="block text-sm font-medium text-gray-700">Camper</label>
                <select multiple name="camper_id[]" id="camper_id" required class="w-full rounded-md border border-gray-300 p-2">                    
                    @foreach($campers as $camper)
                        <option value="{{ $camper->id }}" 
                            {{ isset($camp_enrollment) && $camp_enrollment->camper_id == $camper->id ? 'selected' : '' }}>
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
                            {{ isset($camp_enrollment) && $camp_enrollment->week_id == $week->id ? 'selected' : '' }}>
                            Week {{ $week->week_number }} ({{ $week->start_date }} - {{ $week->end_date }})
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
                    <option value="AM" {{ isset($camp_enrollment) && $camp_enrollment->time_slot == 'AM' ? 'selected' : '' }}>AM</option>
                    <option value="PM" {{ isset($camp_enrollment) && $camp_enrollment->time_slot == 'PM' ? 'selected' : '' }}>PM</option>
                    <option value="Night" {{ isset($camp_enrollment) && $camp_enrollment->time_slot == 'Night' ? 'selected' : '' }}>Night</option>
                </select>
            </div>
            <div>
                <label for="booked" class="block text-sm font-medium text-gray-700">Booked</label>
                <select name="booked" id="booked" required class="w-full rounded-md border border-gray-300 p-2">
                    <option value=""></option>
                    <option value="1" {{ isset($camp_enrollment) && $camp_enrollment->booked == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ isset($camp_enrollment) && $camp_enrollment->booked == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('camp_enrollment.index') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                {{ isset($camp_enrollment) ? 'Update' : 'Create' }} Enrollment
            </button>
        </div>
    </form>
</div>

</x-app-layout>
