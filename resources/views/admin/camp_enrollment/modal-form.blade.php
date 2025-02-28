
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
                class="w-full rounded-md border border-gray-300 p-2">
        </div>

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
        </div>
    </div>

