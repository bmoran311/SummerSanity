<x-app-layout>

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
            @foreach($campers as $camper)
                @foreach($time_slots as $time_slot)
                    { camper: "{{ $camper->first_name }}", 
                        timeslot: "{{ $time_slot }}", 
                        @foreach($weeks as $week)
                            week{{ $week->week_number }}: "{{ $camp_enrollment_array[$camper->id][$time_slot][$week->week_number] ?? '' }}", 
                        @endforeach  
                        @foreach($weeks as $week)                                        
                            week{{ $week->week_number }}_color: "{{ $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] ?? '' }}", 
                        @endforeach                           
                    },
                @endforeach                
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
</x-app-layout>