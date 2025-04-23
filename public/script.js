import { EventType, tableData } from "./tableData.js";

const loginButton = document.getElementById("btn--login");

loginButton?.addEventListener("click", (e) => {
    console.log("clicked");
    window.location.href = "dashboard.html";
});

const generateEventCard = (data) => {
    return `
        <div class="event-card ${data.userChild ? `user-child ${data.bookingType}` : ""}">
            ${!data.userChild ? `<div class="booking-type ${data.bookingType}"></div>` : ""}
            <img src="/assets/icons/${!data?.userChild && data.eventType === EventType.DAY_CAMP_AM ? `${data.eventType}-yellow` : data.eventType}.svg" alt="${
        data.eventType
    } icon" />
            <div class="card__content">
                <span class="event-name">${data.eventName}</span>
                ${data.eventTypeLabel ? `<span class="event-type">${data.eventTypeLabel}</span>` : ""}
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
        {
            title: "My Kid 1",
            field: "myKid1",
            sorter: "string",
            formatter: function (cell, formatterParams) {
                const data = cell.getValue(); // assuming it's an object
                return data ? generateEventCard(data) : "";
            },
        },
        {
            title: "My Kid 2",
            field: "myKid2",
            sorter: "string",
            formatter: function (cell, formatterParams) {
                const data = cell.getValue(); // assuming it's an object
                return data ? generateEventCard(data) : "";
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
        if (document.getElementById(elementId).checked) {
            columns.push({
                title: name,
                field: elementId,
                sorter: "string",
                formatter: function (cell, formatterParams) {
                    const data = cell.getValue(); // assuming it's an object
                    return data ? generateEventCard(data) : "";
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
