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
                            $groupId = $camp_enrollment_group_id_array[$camper->id][$time_slot][$week->week_number] ?? null;
                            $enrollmentId = $camp_enrollment_id_array[$camper->id][$time_slot][$week->week_number] ?? null;
                            $registrationURL = $camp_enrollment_url_array[$camper->id][$time_slot][$week->week_number] ?? null;
                            $notes = $camp_enrollment_notes_array[$camper->id][$time_slot][$week->week_number] ?? null;
                        @endphp

                        @if($eventName)
                            @php                                
                                if (!isset($enrollments[$eventName])) {
                                    $enrollments[$eventName] = [
                                        'eventType' => $eventType,
                                        'bookingColor' => $bookingColor,
                                        'groupId' => $groupId,
                                        'enrollmentId' => $enrollmentId,
                                        'registrationURL' => $registrationURL,
                                        'notes' => $notes,
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
                                    enrollment_id: '{{ $details['enrollmentId'] }}',
                                    eventName: "{{ $name }}",
                                    @if($details['eventType'] == "Morning Camp")
                                        eventType: EventType.DAY_CAMP_AM,
                                    @elseif($details['eventType'] == "Afternoon Camp" || $details['eventType'] == "Day Camp"|| $details['eventType'] == "All Day Camp")
                                        eventType: EventType.DAY_CAMP_PM,
                                    @elseif($details['eventType'] == "Overnight Camp")
                                        eventType: EventType.NIGHT_CAMP,
                                    @elseif($details['eventType'] == "Vacation")
                                        eventType: EventType.VACATION,
                                    @else
                                        eventType: EventType.BABYSITTER,
                                    @endif
                                    eventTypeLabel: "{{ $details['eventType'] }}",
                                    registrationURL: {!! json_encode($details['registrationURL']) !!},
                                    notes: {!! json_encode(
										isset($details['notes']) && $details['notes'] !== null
											? mb_convert_encoding($details['notes'], 'UTF-8', 'UTF-8')
											: null
									) !!},
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
                            $registrationURL = $camp_enrollment_url_array[$friends_camper->id][$time_slot][$week->week_number] ?? null;
                            $notes = $camp_enrollment_notes_array[$friends_camper->id][$time_slot][$week->week_number] ?? null;
                        @endphp

                        @if($eventName)
                            @php
                                if (!isset($enrollments[$eventName])) {
                                    $enrollments[$eventName] = [
                                        'eventType' => $eventType,
                                        'registrationURL' => $registrationURL,
                                        'notes' => $notes,
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
                                    @elseif($details['eventType'] == "Afternoon Camp" || $details['eventType'] == "Day Camp" || $details['eventType'] == "All Day Camp") 
                                        eventType: EventType.DAY_CAMP_PM,
                                    @elseif($details['eventType'] == "Overnight Camp")
                                        eventType: EventType.NIGHT_CAMP,
                                    @elseif($details['eventType'] == "Vacation")
                                        eventType: EventType.VACATION,
                                    @else
                                        eventType: EventType.BABYSITTER,
                                    @endif
                                    eventTypeLabel: "{{ $details['eventType'] }}",
                                    registrationURL: {!! json_encode($details['registrationURL']) !!},
                                    notes: {!! json_encode(
										isset($details['notes']) && $details['notes'] !== null
											? mb_convert_encoding($details['notes'], 'UTF-8', 'UTF-8')
											: null
									) !!},
                                    bookingType: {{ ($details['bookingColor'] ?? '') === 'yellow' ? 'BookingType.CONFIRMED' : 'BookingType.TENTATIVE' }},
                                    userChild: false,
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
        window.location.href = "/my-dashboard";
    });

    const escapeHtml = (unsafe) => {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    };

    const generateEventCard = (data) => {              

        if (Array.isArray(data)) {
            // Multiple plans in the same cell
            return data.map(generateEventCard).join("");
        }

        const isUserChild = data.userChild;
        const bookingClass = `${isUserChild ? "user-child" : ""} ${data.bookingType}`;
        
        let iconName = data.eventType || "default";

        if (!isUserChild && iconName === "daycamp" && data.eventTypeLabel === "Morning Camp") {
            iconName = "daycamp-yellow";
        }

        const eventTypeLabel = data.eventTypeLabel
            ? `<span class="event-type">${data.eventTypeLabel}</span>`
            : "";

        const editButton = data.userChild
            ? `<div class="edit-btn"><img src="assets/icons/edit.svg" alt="Edit Icon" /></div>`
            : "";             
        
        const registerLink = (!data.userChild && data.registrationURL)
            ? `<a href="${data.registrationURL}" target="_blank" class="register-link">
                <img src="/assets/icons/www.png" alt="Register" style="width: 16px; height: 16px;" />
            </a>`
            : "";    
            
        const hasNotes = data.notes && data.notes.trim().length > 0;
        const notesEscaped = escapeHtml(data.notes || "");

        const notesIcon = (!data.userChild && hasNotes)
            ? `<div class="notes-icon" data-notes="${notesEscaped.replace(/"/g, '&quot;')}" onclick="handleNotesClick(event)">
                    <img src="/assets/icons/notes.png" alt="Notes" style="width: 16px; height: 16px;" />
                </div>`
            : "";

        return `
            <div class="event-card ${bookingClass}" data-id="${data.enrollment_id}">
                <img src="/assets/icons/${iconName}.svg" alt="${data.eventType} icon" />
                <div class="card__content">
                    <span class="event-name">${data.eventName}</span>
                    <div class="event-second-line">
                        ${eventTypeLabel}
                        ${editButton}
                        ${registerLink}
                        ${notesIcon}
                    </div>
                </div>
            </div>
        `;
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
                    formatter: function (cell) {
                        const data = cell.getValue();

                        const addButton = `
                            <button id="add-plan-btn"
                                onclick="openAddPlanModal('${cell.getRow().getData()?.week}', '${cell.getColumn().getField()}')"
                                class="btn btn--sm">+ <span>Add</span>
                            </button>`;

                        return `
                            <div class="event-card-wrapper">
                                ${addButton}
                                ${Array.isArray(data) ? data.map(child => generateEventCard(child)).join("") : (data ? generateEventCard(data) : "")}
                            </div>
                        `;
                    },
                    cellClick: (e, cell) => {
                        const isAddBtn = e.target.closest("#add-plan-btn");

                        if (isAddBtn) {
                            const camper_id = document.getElementById('modal_camper_id');
                            const week_id = document.getElementById('modal_week_id');

                            const column = cell.getColumn();
                            camper_id.value = column.getDefinition().id;
                            week_id.value = cell.getRow().getData().week_id;

                            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'enrollment_create' }));
                            return;
                        }

                        const cellValue = cell.getValue();

                        if (cellValue) {
                            // Existing logic to handle click on populated cell (Edit)
                            const isMobileOrTablet = window.matchMedia("(max-width: 1024px)").matches;
                            
                            const eventBlock = e.target.closest(".event-card");
                            if (eventBlock) 
                            {
                                const dataId = eventBlock.getAttribute("data-id");
                                if (dataId) {
                                    window.location.href = '/enrollment/' + dataId + '/edit';
                                    return;
                                }
                            }


                            if (targetElement) {
                                const dataId = targetElement.getAttribute("data-id");
                                if (dataId) {
                                    window.location.href = '/enrollment/' + dataId + '/edit';
                                }
                            }
                        }
                        else
                        {
                            const camper_id = document.getElementById('modal_camper_id');
                            const week_id = document.getElementById('modal_week_id');

                            const column = cell.getColumn();
                            camper_id.value = column.getDefinition().id;
                            week_id.value = cell.getRow().getData().week_id;

                            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'enrollment_create' }));
                        }
                    }
                },
            @endforeach
        ];

        const friendsChild = [
            @foreach($friends_campers as $friends_camper)
                { name: "{{ $friends_camper->first_name }} {{ $friends_camper->last_name }}", elementId: "friend{{ $loop->iteration }}" },
            @endforeach
        ];

        friendsChild.forEach(({ name, elementId }) => {
            if (document.getElementById(elementId)?.checked) {
                columns.push({
                    title: name,
                    field: elementId,
                    sorter: "string",
                    formatter: function (cell) {
                        const data = cell.getValue();
                        return data ? generateEventCard(data) : "";
                    },
                    cellClick: (e, cell) => {
                        const isMobileOrTablet = window.matchMedia("(max-width: 1024px)").matches;
                        let targetElement = null;

                        if (isMobileOrTablet) {
                            const eventBlock = e.target.closest(".event-card");
                            if (eventBlock) {
                                targetElement = eventBlock;
                            }
                        } else {
                            if (e.target.classList.contains("edit-btn")) {
                                targetElement = e.target;
                            }
                        }

                        if (targetElement) {
                            const dataId = targetElement.getAttribute("data-id");
                            if (dataId) {
                                showEditModal(cell, e, dataId);
                            }
                        }
                    },
                });
            }
        });

        return columns;
    };

    // Create Tabulator instance
    var table = new Tabulator("#summer-calendar", {
        data: tableData, // Assign data
        layout: "fitDataTable", // Auto-fit columns to container width
        columns: getColumns(),
    });

    document.querySelectorAll(".friend-child-checkbox").forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            table.setColumns(getColumns());
        });
    });
                
    flatpickr("#date-picker", {
        // defaultDate: new Date("2025-04-15"),
        dateFormat: "F j, Y",
    });
</script>