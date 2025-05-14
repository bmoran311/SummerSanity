import { BookingType, EventType, tableData } from "./tableData.js";

const loginButton = document.getElementById("btn--login");

loginButton?.addEventListener("click", (e) => {
    console.log("clicked");
    window.location.href = "dashboard.html";
});

const generateEventCard = (data) => {
    return `
        <div class="event-card ${data.userChild ? `user-child ${data.bookingType}` : ""}" data-id="${data.eventName}-${data.eventType}">
            ${!data.userChild ? `<div class="booking-type ${data.bookingType}"></div>` : ""}
            <img src="/assets/icons/${!data?.userChild && data.eventType === EventType.DAY_CAMP_AM ? `${data.eventType}-yellow` : data.eventType}.svg" alt="${
        data.eventType
    } icon" />
            <div class="card__content">
                <span class="event-name">${data.eventName}</span>
                <div class="event-second-line">
                    ${data.eventTypeLabel ? `<span class="event-type">${data.eventTypeLabel}</span>` : ""}
                    ${data.userChild ? `<div class="edit-btn" data-id="${data.eventName}-${data.eventType}"><img src="/assets/icons/edit.svg" alt="Edit Icon" /></div>` : ""}
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
        {
            title: "My Kid 1",
            field: "myKid1",
            sorter: "string",
            formatter: function (cell, formatterParams) {
                const data = cell.getValue();
                return `
                    <div class="event-card-wrapper">
                        ${data ? data.map((child) => generateEventCard(child)).join("") : ""}
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
        },
        {
            title: "My Kid 2",
            field: "myKid2",
            sorter: "string",
            formatter: function (cell, formatterParams) {
                const data = cell.getValue(); // assuming it's an object
                return `
                <div class="event-card-wrapper">
                ${data ? data.map((child) => generateEventCard(child)).join("") : ""}
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
        },
    ];

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
                    const data = cell.getValue(); // assuming it's an object
                    return `
                    <div class="event-card-wrapper">
                        ${data ? data.map((child) => generateEventCard(child)).join("") : ""}
                    </div>
                `;
                    // return data ? generateEventCard(data) : "";
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

const weekDisplayFormat = (selectedDates, instance) => {
    if (!selectedDates.length) return;

    const selectedDate = selectedDates[0];

    const start = new Date(selectedDate);
    start.setDate(start.getDate() - start.getDay());

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
    console.log(data);
    const dataId = data.id || el.dataset?.id;
    const [eventName, eventType] = dataId.split("-");
    const clickedEvent = data?.events?.find((event) => event.eventName === eventName && event.eventType === eventType);
    console.log(clickedEvent);
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
