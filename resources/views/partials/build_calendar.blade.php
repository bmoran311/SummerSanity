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
                        @endphp

                        @if($eventName)
                            @php
                                // Only add if this eventName hasn't been added yet
                                if (!isset($enrollments[$eventName])) {
                                    $enrollments[$eventName] = [
                                        'eventType' => $eventType,
                                        'bookingColor' => $bookingColor,
                                        'groupId' => $groupId,
                                        'enrollmentId' => $enrollmentId,
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
        window.location.href = "/my-dashboard";
    });

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
            ? `<div class="edit-btn" data-id="${data.enrollment_id}"><img src="assets/icons/edit.svg" alt="Edit Icon" /></div>`
            : "";

        return `
            <div class="event-card ${bookingClass}">
                <img src="/assets/icons/${iconName}.svg" alt="${data.eventType} icon" />
                <div class="card__content">
                    <span class="event-name">${data.eventName}</span>
                    <div class="event-second-line">
                        ${eventTypeLabel}
                        ${editButton}
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
                        return data ? generateEventCard(data) : "";
                    },
                    cellClick: (e, cell) => {
                        const cellValue = cell.getValue();

                        if (cellValue) {
                            // Existing logic to handle click on populated cell (Edit)
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