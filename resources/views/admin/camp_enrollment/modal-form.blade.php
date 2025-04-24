
    <input type="hidden" name="guardian_id" value="{{$guardian->id}}">

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="camper_id" class="block text-sm font-medium text-gray-700">Camper</label>
            <select multiple name="camper_id[]" id="modal_camper_id" required class="w-full rounded-md border border-gray-300 p-2">
                @foreach($campers as $camper)
                    <option value="{{ $camper->id }}">
                        {{ $camper->first_name }} {{ $camper->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="week_id" class="block text-sm font-medium text-gray-700">Week</label>
            <select multiple name="week_id[]" id="modal_week_id" required class="w-full rounded-md border border-gray-300 p-2">
                @foreach($weeks as $week)
                    <option value="{{ $week->id }}">
                        Week {{ $week->week_number }} ({{ \Carbon\Carbon::parse($week->start_date)->format('n/j') }} - {{ \Carbon\Carbon::parse($week->end_date)->format('n/j') }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2">
            <label for="camp_name" class="block text-sm font-medium text-gray-700">Camp Name</label>
            <input type="text" name="camp_name" required id="camp_input"
                class="w-full rounded-md border border-gray-300 p-2"
                list="camp_name_list"
                >
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
            <select multiple name="time_slot[]" id="modal_time_slot" required class="w-full rounded-md border border-gray-300 p-2">
                @foreach(['AM', 'PM', 'Night'] as $slot)
                    <option value="{{ $slot }}">
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
        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-label for="start_day">Start Day</x-label>
                <select name="start_day" class="w-full rounded-md border border-gray-300 p-2">
                    <option value=""></option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday" selected>Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>

            <div>
                <x-label for="end_day">End Day</x-label>
                <select name="end_day" class="w-full rounded-md border border-gray-300 p-2">
                    <option value=""></option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday" selected>Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-label for="start_time">Start Time</x-label>
                <input type="time" name="start_time" class="w-full rounded-md border border-gray-300 p-2" value="{{ old('start_time', '09:00') }}" />
            </div>

            <div>
                <x-label for="end_time">End Time</x-label>
                <input type="time" name="end_time" class="w-full rounded-md border border-gray-300 p-2" value="{{ old('end_time', '15:00') }}" />
            </div>
        </div>
    </div>

