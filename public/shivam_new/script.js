import { BookingType, DEFAULT_SUMMER_END_DATE, DEFAULT_SUMMER_START_DATE, EventType, tableData } from "./tableData.js";

const loginButton = document.getElementById("btn--login");

loginButton?.addEventListener("click", (e) => {
    console.log("clicked");
    window.location.href = "dashboard.html";
});

const generateEventCard = (data) => {
    return `
        <div class="event-card ${data.userChild ? `user-child ${data.bookingType}` : ""}" data-id="${data.eventName}-${data.eventType}">
            ${!data.userChild ? `<div class="booking-type ${data.bookingType}"></div>` : ""}
            <img src="assets/icons/${!data?.userChild && data.eventType === EventType.DAY_CAMP_AM ? `${data.eventType}-yellow` : data.eventType}.svg" alt="${
        data.eventType
    } icon" />
            <div class="card__content">
                <span class="event-name">${data.eventName}</span>
                <div class="event-second-line">
                    ${data.eventTypeLabel ? `<span class="event-type">${data.eventTypeLabel}</span>` : ""}
                    ${data.userChild ? `<div class="edit-btn" data-id="${data.eventName}-${data.eventType}"><img src="assets/icons/edit.svg" alt="Edit Icon" /></div>` : ""}
                </div>
            </div>
        </div>
    `;
};

const showEditModal = (cell, event, id = null) => {
    openEditModal(
        {
            week: cell.getRow().getData()?.week,
            kid: cell.getColumn().getField(),
            events: cell.getValue(),
            id,
        },
        event.target
    );
};

function openAddPlanModal(week, kid) {
    prefillAddPlanForm(week, kid);
    showModal(addPlanModalOverlay);
}

window.openAddPlanModal = openAddPlanModal;

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
    ];

    const usersChild = [
        { name: "My Kid 1", elementId: "myKid1" },
        { name: "My Kid 2", elementId: "myKid2" },
    ];

    usersChild.forEach(({ name, elementId }) => {
        if (document.getElementById(elementId)?.checked) {
            columns.push({
                title: name,
                field: elementId,
                sorter: "string",
                formatter: function (cell, formatterParams) {
                    const data = cell.getValue();

                    return `
                    <div class="event-card-wrapper">
                        <button id="add-plan-btn" onclick="openAddPlanModal('${cell.getRow().getData()?.week}', '${cell
                        .getColumn()
                        .getField()}')" class="btn btn--sm">+ <span>Add</span>
                        </button>
                        ${Array.isArray(data) ? data.map((child) => generateEventCard(child)).join("") : ""}

                    </div>
                `;
                    // return data ? generateEventCard(data) : "";
                },
                cellClick: (e, cell) => {
                    const isMobileOrTablet = window.matchMedia("(max-width: 1024px)").matches;
                    let targetElement = null;

                    if (isMobileOrTablet) {
                        // Mobile: Find nearest event block (click anywhere inside it)
                        const eventBlock = e.target.closest(".event-card");
                        if (eventBlock) {
                            targetElement = eventBlock;
                        }
                    } else {
                        // Desktop: Only respond to edit icon clicks
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

    const friendsChild = [
        { name: "Sally", elementId: "sally" },
        { name: "Campbell", elementId: "campbell" },
        { name: "Lizzie", elementId: "lizzie" },
        { name: "Vaughn", elementId: "vaughn" },
    ];

    friendsChild.forEach(({ name, elementId }) => {
        if (document.getElementById(elementId)?.checked) {
            columns.push({
                title: name,
                field: elementId,
                sorter: "string",
                formatter: function (cell, formatterParams) {
                    const data = cell.getValue();

                    return `
                    <div class="event-card-wrapper">
                        ${Array.isArray(data) ? data.map((child) => generateEventCard(child)).join("") : ""}

                    </div>
                `;
                },
            });
        }
    });

    return columns;
};

const parseDateInputField = (inputSelector) => {
    const dateStr = document.querySelector(inputSelector)?.value?.trim();
    if (!dateStr) return null;

    const firstDate = dateStr.split("to")[0]?.trim();
    const parsedDate = new Date(firstDate);
    return isNaN(parsedDate.getTime()) ? null : parsedDate;
};

const getTableData = () => {
    const summerStartWeek = parseDateInputField("#startWeek") || DEFAULT_SUMMER_START_DATE;
    const summerEndWeek = parseDateInputField("#endWeek") || DEFAULT_SUMMER_END_DATE;

    const data = [];

    let currentWeekStart = new Date(summerStartWeek);

    while (currentWeekStart <= summerEndWeek) {
        const weekStartStr = currentWeekStart.toISOString().split("T")[0]; // e.g., "2025-06-24"

        // Try to find a matching entry in tableData for this week
        const curData =
            tableData.find((entry) => {
                const entryWeekStr = new Date(entry.week).toISOString().split("T")[0];
                return entryWeekStr === weekStartStr;
            }) || {};

        data.push({
            week: new Date(currentWeekStart), // Ensure new object reference
            ...curData,
        });

        // Move to next week
        currentWeekStart.setDate(currentWeekStart.getDate() + 7);
    }

    return data;
};

// Create Tabulator instance
var table = new Tabulator("#summer-calendar", {
    data: getTableData(), // Assign data
    layout: "fitDataTable", // Auto-fit columns to container width
    columns: getColumns(),
});

document.querySelectorAll(".friend-child-checkbox, .user-child-checkbox").forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
        table.setColumns(getColumns());
    });
});

document.querySelectorAll("#startWeek, #endWeek").forEach((input) => {
    input.addEventListener("change", () => {
        table.setData(getTableData());
    });
});

// Invitation Modal

const invitaitonLink = document.getElementById("invitation-link");
const invitationModalOverlay = document.getElementById("invitation-modal-overlay");
const modalCloseBtn = document.querySelector(".close-btn");
const inviteEmailForm = document.getElementById("invite-email-form");

const hideModal = (overlayEl) => {
    overlayEl.classList.add("hide");
};

const showModal = (overlayEl) => {
    overlayEl.classList.remove("hide");
};

invitaitonLink.addEventListener("click", () => {
    showModal(invitationModalOverlay);
});

modalCloseBtn?.addEventListener("click", () => {
    hideModal(invitationModalOverlay);
});

invitationModalOverlay?.addEventListener("click", (e) => {
    const targetEl = e.target;

    if (!targetEl.classList.contains("modal-overlay")) return;

    hideModal(invitationModalOverlay);
});

document.onkeyup = (e) => {
    if (e.key !== "Escape" && !invitationModalOverlay?.classList.contains("hide")) return;

    hideModal(invitationModalOverlay);
};

inviteEmailForm?.addEventListener("submit", (e) => {
    e.preventDefault();
});

/* 
    Edit Plan Modal
*/

function getWeek(date) {
    if (!date || !date.length) return;

    const selectedDate = date[0];

    const start = new Date(selectedDate);
    const day = start.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

    // Adjust start date to the previous Monday
    const diff = day === 0 ? -6 : 1 - day; // if Sunday, go back 6 days; else subtract (day - 1)
    start.setDate(start.getDate() + diff);

    const end = new Date(start);
    end.setDate(start.getDate() + 6);

    return { start, end };
}

const weekDisplayFormat = (selectedDates, instance) => {
    if (!selectedDates.length) return;

    const selectedDate = selectedDates[0];

    const start = new Date(selectedDate);
    const day = start.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

    // Adjust start date to the previous Monday
    const diff = day === 0 ? -6 : 1 - day; // if Sunday, go back 6 days; else subtract (day - 1)
    start.setDate(start.getDate() + diff);

    const end = new Date(start);
    end.setDate(start.getDate() + 6);

    const formatOptions = { month: "short", day: "numeric", year: "numeric" };
    const formatted = `${start.toLocaleDateString("en-US", formatOptions)} to ${end.toLocaleDateString("en-US", formatOptions)}`;

    instance.input.value = formatted;
};

flatpickr("#date-picker", {
    // defaultDate: new Date("2025-04-15"),
    dateFormat: "F j, Y",
});

const weeklyCalendar = flatpickr("#myCalendar", {
    inline: true, // this shows the calendar directly
    plugins: [new weekSelect()],
    defaultDate: "2025-04-15",
    onChange: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
    },
    onReady: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
    },
    locale: {
        firstDayOfWeek: 1, // 0 = Sunday, 1 = Monday
    },
});

// Edit Plan Overlay
const editPlanOverlay = document.getElementById("edit-plan-modal-overlay");
const editPlayCloseBtn = document.querySelector("#edit-plan-modal-overlay .close-btn");

function fillEditForm(data) {
    // Update Event Name
    document.getElementById("campName").value = data?.eventName || "";

    // Update Week
    weeklyCalendar.setDate(data?.week || "", true);

    // Update Event Type
    const eventTypeSelect = document.getElementById("eventType");
    if (eventTypeSelect) {
        let type = data?.eventType || "";
        const campTypes = [EventType.DAY_CAMP_AM, EventType.DAY_CAMP_PM, EventType.FULL_DAY_CAMP, EventType.NIGHT_CAMP];
        if (campTypes.includes(type)) {
            type = "camp";
        }
        console.log(type);
        eventTypeSelect.value = type;
    }

    // Update Booking Type
    const bookingTypeSelect = document.getElementById("booking");
    let booking = data?.bookingType === BookingType.CONFIRMED ? "yes" : "no";
    if (bookingTypeSelect) bookingTypeSelect.value = booking;

    // Update Time Slot
    const eventTypeToTimeSlots = {
        [EventType.DAY_CAMP_AM]: ["am"],
        [EventType.DAY_CAMP_PM]: ["pm"],
        [EventType.NIGHT_CAMP]: ["night"],
        [EventType.FULL_DAY_CAMP]: ["am", "pm"],
    };
    const timeSlotSelect = document.getElementById("timeSlot");
    if (!timeSlotSelect) return;
    const slots = eventTypeToTimeSlots[data?.eventType] || [];
    // Clear previous selection
    [...timeSlotSelect.options].forEach((option) => {
        option.selected = slots.includes(option.value);
    });

    // Update Kid
    const kidsSelect = document.getElementById("kids");
    [...kidsSelect.options].forEach((option) => {
        option.selected = option.value === data?.kid;
    });
}

const openEditModal = (data, el) => {
    showModal(editPlanOverlay);

    const dataId = data.id || el.dataset?.id;
    const [eventName, eventType] = dataId.split("-");
    const clickedEvent = data?.events?.find((event) => event.eventName === eventName && event.eventType === eventType);

    fillEditForm({ ...clickedEvent, kid: data?.kid, week: data?.week });
};

editPlayCloseBtn?.addEventListener("click", () => {
    hideModal(editPlanOverlay);
});

document.onkeyup = (e) => {
    if (e.key !== "Escape" && !editPlanOverlay?.classList.contains("hide")) return;

    hideModal(editPlanOverlay);
};

editPlanOverlay?.addEventListener("click", (e) => {
    const targetEl = e.target;

    if (!targetEl.classList.contains("modal-overlay")) return;

    hideModal(editPlanOverlay);
});

/*
Campers Page
*/

document.querySelectorAll(".camper-item .input__field input").forEach((input) => {
    input.dataset.originalValue = input.value;

    input.addEventListener("blur", () => {
        const trimmed = input.value.trim();

        if (input.value.trim() === "") {
            input.value = input.dataset.originalValue;
        } else {
            // Update the stored original value if changed and not empty
            input.dataset.originalValue = trimmed;
        }
    });
});

// Add Kid Modal
const addKidModalOverlay = document.getElementById("add-kid-modal-overlay");
const addKidButton = document.getElementById("add-kid-btn");
const addKidCloseButton = document.querySelector("#add-kid-modal-overlay .close-btn");

addKidButton?.addEventListener("click", () => {
    showModal(addKidModalOverlay);
});

addKidModalOverlay?.addEventListener("click", (e) => {
    const targetEl = e.target;

    if (!targetEl.classList.contains("modal-overlay")) return;

    hideModal(addKidModalOverlay);
});

addKidCloseButton?.addEventListener("click", () => {
    hideModal(addKidModalOverlay);
});

document.querySelector(".collapse-filter-btn").addEventListener("click", (event) => {
    const closestEl = event.target.closest(".filters");

    console.log(closestEl);

    closestEl?.classList.toggle("collapsed");
});

// Add Plan Modal

const addPlanCalendar = flatpickr("#addPlanCalendar", {
    inline: true, // this shows the calendar directly
    plugins: [new weekSelect()],
    defaultDate: "2025-04-15",
    onChange: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
    },
    onReady: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
    },
    locale: {
        firstDayOfWeek: 1, // 0 = Sunday, 1 = Monday
    },
});

const addPlanModalOverlay = document.getElementById("add-plan-modal-overlay");
const addPlanCloseButton = document.querySelector("#add-plan-modal-overlay .close-btn");

addPlanModalOverlay?.addEventListener("click", (e) => {
    const targetEl = e.target;

    if (!targetEl.classList.contains("modal-overlay")) return;

    hideModal(addPlanModalOverlay);
});

addPlanCloseButton?.addEventListener("click", () => {
    hideModal(addPlanModalOverlay);
});

function prefillAddPlanForm(week, kid) {
    // Update Week
    addPlanCalendar?.setDate(new Date(week), true);

    // Update Kid
    const kidsSelect = document.getElementById("add-plan-kids");
    [...kidsSelect.options].forEach((option) => {
        option.selected = option.value === kid;
    });
}

/*






*/

const startWeek = flatpickr("#startWeek", {
    plugins: [new weekSelect()],
    defaultDate: "2025-06-02",
    onChange: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
        getTableData();
    },
    onReady: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
        getTableData();
    },
    locale: {
        firstDayOfWeek: 1, // 0 = Sunday, 1 = Monday
    },
});

const endWeek = flatpickr("#endWeek", {
    plugins: [new weekSelect()],
    defaultDate: "2025-08-18",
    onChange: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
        getTableData();
    },
    onReady: function (selectedDates, _, instance) {
        weekDisplayFormat(selectedDates, instance);
        getTableData();
    },
    locale: {
        firstDayOfWeek: 1, // 0 = Sunday, 1 = Monday
    },
});
