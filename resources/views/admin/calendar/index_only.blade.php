<x-app-layout>

<div x-data="{selectedItems: [], open: false}">
    <div class="flex justify-between items-center mb-4">
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

    <div id="calendarContainer" class="space-y-12">
        <!-- Calendar Table Goes Here -->
        <div class="space-y-2">
            <h4 class="font-bold text-lg">Campers of {{ $guardian->first_name }} {{ $guardian->last_name }}</h4>
            <div id="campersTable"></div>
        </div>
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
                        //const prevRow = table.getRowFromPosition(row.getPosition() - 1); // Get the previous row

                        // Apply background color if defined
                        if (rowData[colorKey]) {
                            cell.getElement().style.backgroundColor = rowData[colorKey];
                        }

                        // Check if the previous row has the same camp name (to hide duplicates)
                        //if (prevRow && prevRow.getData()[field] === cellValue && cellValue !== '') {
                        //    return ''; // Hide duplicate occurrences
                        //}

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById('inviteFriendsBtn').addEventListener('click', function (event) {
        event.preventDefault();
        console.log("Invite Friends button clicked.");
        
        html2canvas(document.querySelector("#calendarContainer")).then(canvas => {
            console.log("Canvas rendering complete.");
            
            // Convert canvas to Base64
            let imageData = canvas.toDataURL("image/png");
            
            if (!imageData) {
                alert("Error: Image conversion failed");
                console.error("Base64 conversion failed.");
                return;
            }
            
            console.log("Image converted to Base64 successfully.");
            
            // Set hidden input value
            document.getElementById('screenshotInput').value = imageData;
            
            console.log("Hidden input value set:", document.getElementById('screenshotInput').value);            
            console.log(document.getElementById('screenshotInput').value);           
            console.log(document.getElementById('screenshotInput').value);            
            
            // Submit the form
            document.getElementById('screenshotForm').submit();
        }).catch(error => {
            alert("html2canvas Error: " + error);
            console.error("html2canvas Error:", error);
        });
    });
</script>
@endpush
</x-app-layout>
