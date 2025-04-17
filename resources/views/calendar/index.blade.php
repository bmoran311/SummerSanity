@extends('layouts.subpage')

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
                <h3 class="text-lg font-semibold text-gray-900">Add Plan</h3>
            </div>
            <div class="py-4">
                @include('admin.camp_enrollment.modal-form')
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button x-data="" x-on:click="$dispatch('close')" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Create Plan
                </button>
            </div>
        </form>
    </div>
</x-modal>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
       Summer Calendar
    </h2>
    <form id="screenshotForm" action="/upload-screenshot" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="screenshot" id="screenshotInput">
        <button type="submit" id="inviteFriendsBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Invite Friends
        </button>
    </form>
</div>

<div x-data="{selectedItems: [], open: false}">
    <div class="flex justify-end">
        <div class="relative inline-block text-left" @click.away="open = false">
            <div>
            <button @click="open = !open" type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                Friend's Calendars
                <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
            </div>

            <div x-cloak x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right bg-white shadow-lg ring-1 ring-black/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="p-3 text-sm" role="none">
                    @foreach($friends_campers as $friends_camper)
                        <label class="block space-x-2 items-center flex">
                            <input type="checkbox" class="inline-block" value="{{ $friends_camper->id }}" @change="selectedItems.includes($event.target.value) ? selectedItems = selectedItems.filter(i => i !== $event.target.value) : selectedItems.push($event.target.value)">
                            <span>{{ $friends_camper->first_name }} {{ $friends_camper->last_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-12">
        <div id="calendarContainer">
            <div class="space-y-2">
                <h4 class="font-bold text-lg">Campers of {{ $guardian->first_name }} {{ $guardian->last_name }}</h4>
                <div id="campersTable"></div>
            </div>
        </div>

        @foreach($friends_campers as $friends_camper)
        <div class="space-y-2" x-show="selectedItems.includes('{{ $friends_camper->id }}')" x-cloak>
            <h4 class="font-bold text-lg">Campers of {{ $friends_camper->first_name }} {{ $friends_camper->last_name }}</h4>
            <div id="campersTableFriend{{ $loop->index }}" class="campersTableFriend">
                Content for {{ $friends_camper->first_name }} {{ $friends_camper->last_name }}
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('foot')

<script>
    // Cell click handler
    function handleCellClick(e, cell) {
        const id = cell.getRow().getData().id; // Get the ID from the row data
        const cellValue = cell.getValue();

        if(cellValue) {
            const column = cell.getColumn()
            let week_num = column.getField().replace('week', '');
            let url = cell.getRow().getData()[`week${week_num}_link`];

            return window.location.href = url;
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

    }        
</script>

<script>
    // Tabulator initialization
    var table = new Tabulator("#campersTable", {
        layout: "fitColumns",
        columns: [
            {
                title: "Camper",
                field: "camper",
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
                    // editor: "input",
                    cellClick: handleCellClick,
                    formatter: function(cell) {
                        const field = cell.getField();
                        const rowData = cell.getRow().getData();
                        const colorKey = `${field}_color`;
                        const cellValue = cell.getValue() || '';
                        const row = cell.getRow();
                        const table = row.getTable();

                        const position = row.getPosition();
                        const prevRow = position > 0 ? table.getRowFromPosition(position - 1) : null;
                    
                        // Apply background color if defined
                        if (rowData[colorKey]) {
                            cell.getElement().style.backgroundColor = rowData[colorKey];
                        }

                        // Check if the previous row has the same camp name (to hide duplicates)
                        if (prevRow && prevRow.getData()[field] === cellValue && cellValue !== '') {
                            return ''; // Hide duplicate occurrences
                        }

                        // Make the first occurrence of the camp name clickable
                        if (cellValue) {
                            return `<div class="merged-cell"><a href="${rowData[field + '_link'] || '#'}" 
                                    style="text-decoration: none; color: inherit; display: block; width: 100%; height: 100%;">
                                    ${cellValue}
                                </a></div>`;
                        }

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
        var friendsTable{{ $loop->index }} = new Tabulator("#campersTableFriend{{ $loop->index }}", {
            layout: "fitColumns",
            columns: [
                { title: "Camper", field: "camper",
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
                            const field = cell.getField();
                            const rowData = cell.getRow().getData();
                            const colorKey = `${field}_color`;
                            const cellValue = cell.getValue() || '';
                            const row = cell.getRow();
                            const friendsTable{{ $loop->index }} = row.getTable();

                            const position = row.getPosition();
                            const prevRow = position > 0 ? row.getTable().getRowFromPosition(position - 1) : null;

                            // Apply background color if defined
                            if (rowData[colorKey]) {
                                cell.getElement().style.backgroundColor = rowData[colorKey];
                            }

                            // Check if the previous row has the same camp name (to hide duplicates)
                            if (prevRow && prevRow.getData()[field] === cellValue && cellValue !== '') {
                                return ''; // Hide duplicate occurrences
                            }

                            // Make the first occurrence of the camp name clickable
                            if (cellValue) {
                                return `<div class="merged-cell"><a href="${rowData[field + '_link'] || '#'}" 
                                        style="text-decoration: none; color: inherit; display: block; width: 100%; height: 100%;">
                                        ${cellValue}
                                    </a></div>`;
                            }

                            return cellValue;
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById('inviteFriendsBtn').addEventListener('click', function (event) {
        event.preventDefault();
        
        html2canvas(document.querySelector("#calendarContainer")).then(canvas => {
            console.log("Canvas rendering complete.");
            let imageData = canvas.toDataURL("image/png");
            
            if (!imageData) {
                alert("Error: Image conversion failed");
                console.error("Base64 conversion failed.");
                return;
            }
                        
            document.getElementById('screenshotInput').value = imageData;                 
            
            let formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('screenshot', imageData);
            
            fetch('/upload-screenshot', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.error) {
                      alert("Server Error: " + data.error);
                  } else {
                      window.location.href = "/invite-friends?screenshot=" + encodeURIComponent(data.path);
                  }
              })
              .catch(error => alert("Fetch Error: " + error));
        }).catch(error => {
            alert("html2canvas Error: " + error);
            console.error("html2canvas Error:", error);
        });
    });
</script>

@endpush