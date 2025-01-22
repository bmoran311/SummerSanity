<x-app-layout>
<div id="campersTable"></div>
<br><br>
<div id="campersTableWill"></div>

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
            { title: "6/2-6/6", field: "week1", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week1_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/9-6/13", field: "week2", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week2_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/16-6/20", field: "week3", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week3_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                } 
            },
            { title: "6/23-6/27", field: "week4", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week4_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/30-7/4", field: "week5", editor: "input"
                , 
                formatter: function(cell) {                   
                    const colorKey = "week5_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
             },
            { title: "7/7-7/11", field: "week6", editor: "input"
                , 
                formatter: function(cell) {                   
                    const colorKey = "week6_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
             },
            { title: "7/14-7/18", field: "week7", editor: "input" },
            { title: "7/21-7/25", field: "week8", editor: "input" },
            { title: "7/28-8/1", field: "week9", editor: "input" },
            { title: "8/4-8/8", field: "week10", editor: "input" },
            { title: "8/11-8/15", field: "week11", editor: "input" },
        ],
        data: [
            { camper: "Jax", timeslot: "AM", week1: "Catholic Basketball", week2: "Outdoor Camp", week3: "PCC Golf Camp", week4: "UNC Basketball Camp", week5: "SBA Baseball", week6: "Wildwood, NJ", week7: "Catholic Flag Football", week8: "Mugsy Bogues Basketball", week1_color: "yellow", week4_color: "yellow", week6_color: "yellow" },
            { camper: "Jax", timeslot: "PM", week1: "PCC Pool", week2: "Harris Y Soccer", week4: "UNC Basketball Camp", week6: "Wildwood, NJ",  week4_color: "yellow", week6_color: "yellow" },
            { camper: "Jax", timeslot: "Night", week1: "", week2: "", week4: "UNC Basketball Camp", week6: "Wildwood, NJ", week4_color: "yellow", week6_color: "yellow" },
            { camper: "Alexis", timeslot: "AM", week1: "Catholic Basketball", week2: "Outdoor Camp", week4: "San Diego", week6: "Wildwood, NJ", week6_color: "yellow", week1_color: "yellow", week4_color: "yellow"  },
            { camper: "Alexis", timeslot: "PM", week2: "Harris YMCA Ref", week3: "Harris YMCA Ref", week4: "San Diego", week6: "Wildwood, NJ", week6_color: "yellow", week4_color: "yellow" },
            { camper: "Alexis", timeslot: "Night", week2: "", week4: "San Diego", week6: "Wildwood, NJ", week6_color: "yellow", week4_color: "yellow" },
            { camper: "Mackenzie", timeslot: "AM", week1: "Catholic Basketball", week2: "Outdoor Camp", week6: "Wildwood, NJ", week1_color: "yellow", week6_color: "yellow" },
            { camper: "Mackenzie", timeslot: "PM", week1: "Babysitting Ryan", week2: "Harris YMCA", week3: "Harris YMCA Ref", week6: "Wildwood, NJ", week6_color: "yellow" },
            { camper: "Mackenzie", timeslot: "Night", week1: "", week2: "", week6: "Wildwood, NJ", week6_color: "yellow" },
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


<script>
    // Tabulator initialization
    var table = new Tabulator("#campersTableWill", {
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
            { title: "6/2-6/6", field: "week1", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week1_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/9-6/13", field: "week2", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week2_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/16-6/20", field: "week3", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week3_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                } 
            },
            { title: "6/23-6/27", field: "week4", editor: "input", 
                formatter: function(cell) {                    
                    const colorKey = "week4_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
            },
            { title: "6/30-7/4", field: "week5", editor: "input"
                , 
                formatter: function(cell) {                   
                    const colorKey = "week5_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
             },
            { title: "7/7-7/11", field: "week6", editor: "input"
                , 
                formatter: function(cell) {                   
                    const colorKey = "week6_color";
                    const rowData = cell.getRow().getData();
                    if (rowData[colorKey]) {
                        cell.getElement().style.backgroundColor = rowData[colorKey];
                    }
                    return cell.getValue();
                }
             },
            { title: "7/14-7/18", field: "week7", editor: "input" },
            { title: "7/21-7/25", field: "week8", editor: "input" },
            { title: "7/28-8/1", field: "week9", editor: "input" },
            { title: "8/4-8/8", field: "week10", editor: "input" },
            { title: "8/11-8/15", field: "week11", editor: "input" },
        ],
        data: [
            { camper: "Will Z", timeslot: "AM", week1: "Catholic Basketball", week2: "Adventure Camp WWC", week3: "Queens Soccer", week4: "UNC Basketball Camp", week6: "Ft. Lauderdale, FL", week7: "Catholic Flag Football", week8: "Mugsy Bogues Basketball", week1_color: "yellow", week4_color: "yellow", week6_color: "yellow" },
            { camper: "Will Z", timeslot: "PM", week1: "PCC Pool", week2: "Harris Y Soccer", week4: "UNC Basketball Camp", week6: "Ft. Lauderdale, FL",  week4_color: "yellow", week6_color: "yellow" },
            { camper: "Will Z", timeslot: "Night", week1: "", week2: "", week4: "UNC Basketball Camp", week6: "Ft. Lauderdale, FL", week4_color: "yellow", week6_color: "yellow" },      
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
</x-app-layout>