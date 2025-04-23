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
        <!-- CSS Stylesheet -->
        <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/style.css" />
        <link rel="stylesheet" href="/tabulator.css" />
        <title>Dashboard - Summer Sanity</title>
    </head>
    <body>
        <div class="dashboard">
            <nav class="nav nav--dashboard">
                <div class="logo">
                    <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
                </div>
                <div></div>
            </nav>
            <div class="filter__friends">
				@foreach($friends_campers as $friends_camper)
					<label><input type="checkbox" class="friend-child-checkbox" id="friend{{ $loop->iteration }}" checked />{{ $friends_camper->first_name }} {{ $friends_camper->last_name }}</label>
				@endforeach		                
            </div>
            <div id="summer-calendar"></div>
        </div>

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

        <script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>		
		<script>
			const BookingType = {
				TENTATIVE: "tentative",
				CONFIRMED: "confirmed",
			};

			const EventType = {
				VACATION: "vacation",
				DAY_CAMP_AM: "daycamp",
				DAY_CAMP_PM: "daycamp",
				NIGHT_CAMP: "nightcamp",
				FULL_DAY_CAMP: "fullday",
				BABYSITTER: "babysitter",
			};

			 const EventLabel = {
				VACATION: "Vacation",
				DAY_CAMP: "Day Camp",
				NIGHT_CAMP: "Overnight",
				FULL_DAY_CAMP: "Full Day",
				BABYSITTER: "Babysitter",
			};								

			const tableData = [
				@foreach($weeks as $week)
					{
						week: new Date("{{ \Carbon\Carbon::parse($week->start_date)->format('Y-m-d\TH:i:s') }}"),
						@foreach($campers as $camper)
							myKid{{ $loop->iteration }}: 
							@if(empty($camp_enrollment_array[$camper->id]["AM"][$week->week_number]))
								null,
							@else
								{
									eventName: "{{ $camp_enrollment_array[$camper->id]["AM"][$week->week_number] }}",	
									@if($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Morning Camp")
										eventType: EventType.DAY_CAMP_AM,			
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Afternoon Camp")
										eventType: EventType.DAY_CAMP_PM,
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Day Camp")
										eventType: EventType.DAY_CAMP_PM,
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Overnight Camp")
										eventType: EventType.NIGHT_CAMP,							
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Vacation")
										eventType: EventType.VACATION,										
									@else
										eventType: EventType.BABYSITTER,										
									@endif
									eventTypeLabel: "{{ $camp_enrollment_type_array[$camper->id]["AM"][$week->week_number]}}",
									bookingType: {{ ($camp_enrollment_color_array[$camper->id]["AM"][$week->week_number] ?? '') === 'yellow' ? 'BookingType.CONFIRMED' : 'BookingType.TENTATIVE' }},
									userChild: true,
								},
							@endif
						@endforeach
						@foreach($friends_campers as $friends_camper)
							friend{{ $loop->iteration }}: 
							@if(empty($camp_enrollment_array[$friends_camper->id]["AM"][$week->week_number]))
								null,
							@else
								{
									eventName: "{{ $camp_enrollment_array[$friends_camper->id]["AM"][$week->week_number] }}",									
									@if($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Morning Camp")
										eventType: EventType.DAY_CAMP_AM,			
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Afternoon Camp")
										eventType: EventType.DAY_CAMP_PM,
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Day Camp")
										eventType: EventType.DAY_CAMP_PM,
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Overnight Camp")
										eventType: EventType.NIGHT_CAMP,							
									@elseif($camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] == "Vacation")
										eventType: EventType.VACATION,										
									@else
										eventType: EventType.BABYSITTER,										
									@endif
									eventTypeLabel: "{{ $camp_enrollment_type_array[$camper->id]["AM"][$week->week_number] }}",
									bookingType: {{ ($camp_enrollment_color_array[$friends_camper->id]["AM"][$week->week_number] ?? '') === 'yellow' ? 'BookingType.CONFIRMED' : 'BookingType.TENTATIVE' }},									
								},
							@endif
						@endforeach															
					},
				@endforeach						
			];

		
			const loginButton = document.getElementById("btn--login");

			loginButton?.addEventListener("click", (e) => {
				console.log("clicked");
				window.location.href = "dashboard.html";
			});

			const generateEventCard = (data) => {
				const isUserChild = data.userChild;
				const bookingClass = isUserChild ? "user-child " + data.bookingType : "";
				const bookingTypeDiv = !isUserChild ? '<div class="booking-type ' + data.bookingType + '"></div>' : "";
				const iconName = !isUserChild && data.eventType === EventType.DAY_CAMP_AM
					? data.eventType + "-yellow"
					: data.eventType;
				const eventTypeLabel = data.eventTypeLabel
					? '<span class="event-type">' + data.eventTypeLabel + '</span>'
					: "";

				return (
					'<div class="event-card ' + bookingClass + '">' +
						bookingTypeDiv +
						'<img src="/assets/icons/' + iconName + '.svg" alt="' + data.eventType + ' icon" />' +
						'<div class="card__content">' +
							'<span class="event-name">' + data.eventName + '</span>' +
							eventTypeLabel +
						'</div>' +
					'</div>'
				);
			};

			const getColumns = () => {
				const columns = [
					{
						title: "Weeks",
						field: "week",
						sorter: function (a, b) {
							return new Date(a) - new Date(b);
						},
						frozen: true,
						formatter: function (cell) {
							const date = new Date(cell.getValue());
							return date.toLocaleDateString("en-US", { month: "short", day: "numeric" });
						},
					},
					@foreach($campers as $camper)
						{
							title: "{{ $camper->first_name }}",
							field: "myKid{{ $loop->iteration }}",
							sorter: "string",
							cellClick: handleCellClick,
							formatter: function (cell) {
								const data = cell.getValue();
								return data ? generateEventCard(data) : "";
							},
						},
					@endforeach					
				];

				const friendsChild = [
					@foreach($friends_campers as $friends_camper)
						{ name: "{{ $friends_camper->first_name }} {{ $friends_camper->last_name }}", elementId: "friend{{ $loop->iteration }}" },
					@endforeach																	
				];

				friendsChild.forEach(({ name, elementId }) => {
					if (document.getElementById(elementId).checked) {
						columns.push({
							title: name,
							field: elementId,
							sorter: "string",
							formatter: function (cell) {
								const data = cell.getValue();
								return data ? generateEventCard(data) : "";
							},
						});
					}
				});

				return columns;
			};
		
			function handleCellClick(e, cell) {

				//alert("TEST TEST TEST ");

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


			// Create Tabulator instance
			var table = new Tabulator("#summer-calendar", {
				data: tableData,
				layout: "fitDataTable",
				columns: getColumns(),
			});

			document.querySelectorAll(".friend-child-checkbox").forEach((checkbox) => {
				checkbox.addEventListener("change", () => {
					table.setColumns(getColumns());
				});
			});
		</script>	
    </body>
</html>
