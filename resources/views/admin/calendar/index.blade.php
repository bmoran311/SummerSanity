<x-app-layout>

<x-modal name="enrollment_create" maxWidth="4xl">
    <div class="p-4">
        <form method="POST" action="{{ route('camp_enrollment.store') }}">
            @csrf
            <div class="flex items-center space-x-4 border-b pb-2">
                <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:size-10">
                    <svg class="size-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Add Camp Enrollment</h3>
            </div>
            <div class="py-4">
                @include('admin.camp_enrollment.modal-form')
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button x-data="" x-on:click="$dispatch('close')" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Create Enrollment
                </button>
            </div>
        </form>
    </div>
</x-modal>

<div style="position: fixed; top: 100px; left: 370px; background-color: #fff; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <div style="font-weight: bold; margin-bottom: 8px;">Select friends:</div>
    @foreach($friends_campers as $friends_camper)
        <label style="display: block; margin-bottom: 5px;">
            <input type="checkbox" class="friend-checkbox" data-index="{{ $loop->index }}" style="margin-right: 5px;" checked>
            {{ $friends_camper->last_name }}, {{ $friends_camper->first_name }}
        </label>
    @endforeach
</div>

<br><br><br><br><br><br><br><br><br>
<div id="campersTable"></div>
@foreach($friends_campers as $friends_camper)
    <br>
    <div id="campersTableFriend{{ $loop->index }}" class="campersTableFriend">
        Content for {{ $friends_camper->first_name }} {{ $friends_camper->last_name }}
    </div>
@endforeach

@push('foot')

<script>
    // Cell click handler
    function handleCellClick(e, cell) {
        const id = cell.getRow().getData().id; // Get the ID from the row data
        const cellValue = cell.getValue();

        if(cellValue) {
            //this is where future edit could trigger
            return;
        }else{
            //create new enrollment
            const column = cell.getColumn()
            const time_slot = document.getElementById('modal_time_slot');
            const camper_id = document.getElementById('modal_camper_id');
            const week_id = document.getElementById('modal_week_id');

            let week_num = column.getField().replace('week', '');

            time_slot.value = cell.getRow().getData().timeslot;
            camper_id.value = cell.getRow().getData().id;
            week_id.value = week_num;


            window.dispatchEvent(new CustomEvent('open-modal', {detail: 'enrollment_create'}));

            return;
        }
        // Emit the Livewire event with the ID

    }
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".friend-checkbox").forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    let index = this.getAttribute("data-index");
                    let targetDiv = document.getElementById("campersTableFriend" + index);
                    if (this.checked) {
                        targetDiv.style.display = "block";
                    } else {
                        targetDiv.style.display = "none";
                    }
                });
            });
        });
    </script>

    <script>
        // Tabulator initialization
        var table = new Tabulator("#campersTable", {
            layout: "fitColumns",
            columns: [
                {
                    title: "Camper",
                    field: "camper",
                    rowSpan: 3,
                    formatter: function(cell) {
                        return `<strong>${cell.getValue()}</strong>`;
                    }
                },
                {
                    title: "Time Slot",
                    field: "timeslot",
                    formatter: function(cell) {
                        return `<strong>${cell.getValue()}</strong>`;
                    }
                },
                @foreach($weeks as $week)
                    {
                        title: "{{ \Carbon\Carbon::parse($week->start_date)->format('n/j') }}-{{ \Carbon\Carbon::parse($week->end_date)->format('n/j') }}",
                        field: "week{{ $week->week_number }}",
                        editor: "input",
                        cellClick: handleCellClick,
                        formatter: function(cell) {
                            const field = cell.getField();
                            const rowData = cell.getRow().getData();
                            const colorKey = `${field}_color`;
                            const cellValue = cell.getValue() || '';

                            // Set background color if defined
                            if (rowData[colorKey]) {
                                cell.getElement().style.backgroundColor = rowData[colorKey];
                            }

                            // Make the cell clickable with the dynamic link
                            return cellValue;
                        }
                    },
                @endforeach
            ],
            data: [
                @foreach($campers as $camper)
                    @foreach($time_slots as $time_slot)
                        {
                            id: "{{ $camper->id }}",
                            camper: "{{ $camper->first_name }}",
                            timeslot: "{{ $time_slot }}",
                            @foreach($weeks as $week)
                                week{{ $week->week_number }}: "{{ $camp_enrollment_array[$camper->id][$time_slot][$week->week_number] ?? '' }}",
                                @if(strlen($camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number]))
                                    week{{ $week->week_number }}_link: "/camp_enrollment/{{ $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] }}/edit",
                                @else
                                    week{{ $week->week_number }}_link: "/camp_enrollment/create?week={{ $week->id }}&time_slot={{ urlencode($time_slot) }}&guardian_id={{ $guardian->id }}&camper_id={{ $camper->id }}",
                                @endif
                            @endforeach
                            @foreach($weeks as $week)
                                week{{ $week->week_number }}_color: "{{ $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] ?? '' }}",
                            @endforeach
                        },
                    @endforeach
                @endforeach
            ],
        });
    </script>

    @foreach($friends_campers as $friends_camper)
        <script>
            // Tabulator initialization
            var table = new Tabulator("#campersTableFriend{{ $loop->index }}", {
                layout: "fitColumns",
                columns: [
                    { title: "Camper", field: "camper", rowSpan: 3,
                        formatter: function(cell) {
                            return `<strong>${cell.getValue()}</strong>`;
                        }
                    },
                    { title: "Time Slot", field: "timeslot",
                        formatter: function(cell) {
                            return `<strong>${cell.getValue()}</strong>`;
                        }
                    },
                    @foreach($weeks as $week)
                        { title: "{{ \Carbon\Carbon::parse($week->start_date)->format('n/j') }}-{{ \Carbon\Carbon::parse($week->end_date)->format('n/j') }}", field: "week{{ $week->week_number }}", editor: "input",
                            formatter: function(cell) {
                                const colorKey = "week{{ $week->week_number }}_color";
                                const rowData = cell.getRow().getData();
                                if (rowData[colorKey]) {
                                    cell.getElement().style.backgroundColor = rowData[colorKey];
                                }
                                return cell.getValue();
                            }
                        },
                    @endforeach
                ],
                data: [
                    @foreach($time_slots as $time_slot)
                        { camper: "{{ $friends_camper->first_name }}",
                            timeslot: "{{ $time_slot }}",
                            @foreach($weeks as $week)
                                week{{ $week->week_number }}: "{{ $camp_enrollment_array[$friends_camper->id][$time_slot][$week->week_number] ?? '' }}",
                            @endforeach
                            @foreach($weeks as $week)
                                week{{ $week->week_number }}_color: "{{ $camp_enrollment_color_array[$friends_camper->id][$time_slot][$week->week_number] ?? '' }}",
                            @endforeach
                        },
                    @endforeach
                ],
                cellFormatter: function (cell) {
                    const field = cell.getField();
                    const rowData = cell.getRow().getData();
                    const colorKey = `${field}_color`;
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                },
            });
        </script>
    @endforeach

@endpush
</x-app-layout>
