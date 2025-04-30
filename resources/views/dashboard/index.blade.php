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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="dashboard">
            <nav class="nav nav--dashboard">
                <div class="logo">
                    <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
                </div>
				<ul class="nav__links">
					<li class="nav__link"><a href="/dashboard.html">Dashboard</a></li>
					<li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>
				</ul>
				<div class="profile">
					<img src="assets/megan-p-profile-pic.jpg" alt="User Profile Picture" />
					<span>Megan Petrik</span>
				</div>                 
            </nav>
            <div class="filter__friends">
				@foreach($friends_campers as $friends_camper)
					<label><input type="checkbox" class="friend-child-checkbox" id="friend{{ $loop->iteration }}" checked />{{ $friends_camper->first_name }} {{ $friends_camper->last_name }}</label>
				@endforeach
            </div>
            <div id="summer-calendar"></div>
        </div>

		<div id="invitation-modal-overlay" class="modal-overlay hide">
            <div class="card modal invitation-modal">
                <div class="gradient"></div>
                <div class="close-btn"><img src="assets/icons/close.svg" /></div>
                <div class="header">
                    <img src="assets/icons/register.svg" alt="Register Icon" />
                    <h4>Invite & Simplify Summer Together!</h4>
                    <p>Send an invite to friends and family to share schedules and plan activities.</p>
                </div>
                <div class="modal__main">                    
                    <div class="left">						
						<form id="invite-email-form" method="POST" action="{{ route('invite.friends') }}">
							@csrf
                            <label class="field__label" for="emails">Enter friends’ emails (comma-separated)</label>
                            <div class="input__field">
                                <img src="assets/icons/email.svg" alt="Profile icon" />
                                <input type="text" placeholder="friend1@example.com, friend2@example.com" name="emails" id="emails" class="input__email" />
                                <button type="submit" class="btn btn--sm">Send</button>
                            </div>
                        </form>
                        <div class="line-separator"></div>
                        <!-- Invite History -->
                        <div class="invite-history-container">
                            <div class="field__label">Invite History</div>
                            <div class="invites-list">                                
                                @foreach($friends as $friend)
									<div class="invite-item">
										<div class="invite-item__main">
											<span class="name">{{ $friend->first_name }} {{ $friend->last_name }} </span>
											<span class="email">{{ $friend->email }}</span>
										</div>
										<div class="state">Accepted</div>
									</div>
                                @endforeach                                
                                <div class="invite-item">
                                    <div class="invite-item__main">
                                        <span class="name">Tyler Murphy</span>
                                        <span class="email">typermurphy@gmail.com</span>
                                    </div>
                                    <div class="resend-btn">
                                        <img src="assets/icons/resend.svg" alt="Resent Invite Icon" />
                                    </div>
                                    <div class="state state--pending">Pending</div>
                                </div>                                
                            </div>
                        </div>                        
                    </div>                    
                    <!-- Modal Right Content -->
                    <div class="right">
                        <div>
                            <div class="field__label">Email Preview</div>
                        </div>
                        <div class="email-preview">
                            <h3 class="subject">Let’s Coordinate Summer Plans - Join Me on Summer Sanity!</h3>
                            <div class="description">
                                <p>Hello <span class="bold">[friend-name]</span>,</p>
                                <p>
                                    I just joined this awesome parenting site called <span class="bold">Summer Sanity</span> to help plan my kid's summer schedule, and I think
                                    you'll love it too!
                                </p>
                                <p>It's completely free and makes it easy for parents like us to organize summer schedules and share plans with friends.</p>
                                <p>
                                    Here’s the best part: if we connect our calendars, we can swap ideas for camps and activities and make sure the kids get plenty of time together
                                    this summer—it’s a win-win!
                                </p>
                                <p class="bold">Take a look at how easy it is to use:</p>
                                <img src="assets/calendar.png" alt="Summer Calendar" />
                                <p class="bold">Click below to join me and start planning:</p>
                                <button class="btn btn--sm">Join Summer Sanity!</button>
                                <div class="email-footer">
                                    <p>Can't wait to see what we come up with!</p>
                                    <p class="bold">Megan Petrik</p>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>                
            </div>
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
                        week_id: '{{ $week->id }}',
						@foreach($campers as $camper)
							myKid{{ $loop->iteration }}: 
							@php
								$enrollments = [];
							@endphp

							@foreach($time_slots as $time_slot)
								@php
									$eventName = $camp_enrollment_array[$camper->id][$time_slot][$week->week_number] ?? null;
									$eventType = $camp_enrollment_type_array[$camper->id][$time_slot][$week->week_number] ?? null;
									$bookingColor = $camp_enrollment_color_array[$camper->id][$time_slot][$week->week_number] ?? null;
								@endphp

								@if($eventName)
									@php
										// Only add if this eventName hasn't been added yet
										if (!isset($enrollments[$eventName])) {
											$enrollments[$eventName] = [
												'eventType' => $eventType,
												'bookingColor' => $bookingColor,
											];
										}
									@endphp
								@endif
							@endforeach

							@if(empty($enrollments))
								null,
							@else
								[
									@foreach($enrollments as $name => $details)
										{
											eventName: "{{ $name }}",
											@if($details['eventType'] == "Morning Camp")
												eventType: EventType.DAY_CAMP_AM,
											@elseif($details['eventType'] == "Afternoon Camp" || $details['eventType'] == "Day Camp")
												eventType: EventType.DAY_CAMP_PM,
											@elseif($details['eventType'] == "Overnight Camp")
												eventType: EventType.NIGHT_CAMP,
											@elseif($details['eventType'] == "Vacation")
												eventType: EventType.VACATION,
											@else
												eventType: EventType.BABYSITTER,
											@endif
											eventTypeLabel: "{{ $details['eventType'] }}",
											bookingType: {{ ($details['bookingColor'] ?? '') === 'yellow' ? 'BookingType.CONFIRMED' : 'BookingType.TENTATIVE' }},
											userChild: true,
										},
									@endforeach
								],
							@endif
						@endforeach

						@foreach($friends_campers as $friends_camper)
							friend{{ $loop->iteration }}: 
							@php
								$enrollments = [];
							@endphp

							@foreach($time_slots as $time_slot)
								@php
									$eventName = $camp_enrollment_array[$friends_camper->id][$time_slot][$week->week_number] ?? null;
									$eventType = $camp_enrollment_type_array[$friends_camper->id][$time_slot][$week->week_number] ?? null;
									$bookingColor = $camp_enrollment_color_array[$friends_camper->id][$time_slot][$week->week_number] ?? null;
								@endphp

								@if($eventName)
									@php
										if (!isset($enrollments[$eventName])) {
											$enrollments[$eventName] = [
												'eventType' => $eventType,
												'bookingColor' => $bookingColor,
											];
										}
									@endphp
								@endif
							@endforeach

							@if(empty($enrollments))
								null,
							@else
								[
									@foreach($enrollments as $name => $details)
										{
											eventName: "{{ $name }}",
											@if($details['eventType'] == "Morning Camp")
												eventType: EventType.DAY_CAMP_AM,
											@elseif($details['eventType'] == "Afternoon Camp" || $details['eventType'] == "Day Camp")
												eventType: EventType.DAY_CAMP_PM,
											@elseif($details['eventType'] == "Overnight Camp")
												eventType: EventType.NIGHT_CAMP,
											@elseif($details['eventType'] == "Vacation")
												eventType: EventType.VACATION,
											@else
												eventType: EventType.BABYSITTER,
											@endif
											eventTypeLabel: "{{ $details['eventType'] }}",
											bookingType: {{ ($details['bookingColor'] ?? '') === 'yellow' ? 'BookingType.CONFIRMED' : 'BookingType.TENTATIVE' }},
										},
									@endforeach
								],
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
				if (Array.isArray(data)) {
					// Multiple plans in the same cell
					return data.map(generateEventCard).join("");
				}

				const isUserChild = data.userChild;
				const bookingClass = isUserChild ? "user-child " + data.bookingType : "";
				const bookingTypeDiv = !isUserChild ? '<div class="booking-type ' + data.bookingType + '"></div>' : "";

				let iconName = data.eventType || "default";

				if (!isUserChild && iconName === "daycamp" && data.eventTypeLabel === "Morning Camp") {
					iconName = "daycamp-yellow";
				}

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
                            //id: "{{ $camper->id }}",
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

                const cellValue = cell.getValue();

				if(cellValue) {
                    alert('need to get enrollment id');
                    const data = cell.getRow().getData(); // Get the ID from the row data

                    console.log(data, cellValue)
				}else{

					const camper_id = document.getElementById('modal_camper_id');
					const week_id = document.getElementById('modal_week_id');

                    var column = cell.getColumn();
                    camper_id.value = column.getDefinition().id;
                    week_id.value = cell.getRow().getData().week_id;

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
			
			// Invitation Modal
			const invitaitonLink = document.getElementById("invitation-link");
			const invitationModalOverlay = document.getElementById("invitation-modal-overlay");
			const modalCloseBtn = document.querySelector(".close-btn");
			const inviteEmailForm = document.getElementById("invite-email-form");

			const hideModal = () => {
				invitationModalOverlay.classList.add("hide");
			};

			const showModal = () => {
				invitationModalOverlay.classList.remove("hide");
			};

			invitaitonLink.addEventListener("click", showModal);

			modalCloseBtn.addEventListener("click", hideModal);

			invitationModalOverlay.addEventListener("click", (e) => {
				const targetEl = e.target;

				if (!targetEl.classList.contains("modal-overlay")) return;

				hideModal();
			});

			document.onkeyup = (e) => {
				if (e.key !== "Escape" && !invitationModalOverlay.classList.contains("hide")) return;

				hideModal();
			};

			//inviteEmailForm.addEventListener("submit", (e) => {
			//	e.preventDefault();
			//});
		</script>
    </body>
</html>
