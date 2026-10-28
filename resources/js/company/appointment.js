const detailButtons = document.querySelectorAll(
    '[data-bs-target="#detalhaModal"]'
);

const modalAppointmentId = document.getElementById("modalAppointmentId");
const modalBookingId = document.getElementById("modalBookingId");

const modalAppointmentIdInput = document.getElementById(
    "modalAppointmentIdInput"
);

const modalBookingIdInput = document.getElementById(
    "modalBookingIdInput"
);

const modalClientName = document.getElementById("modalClientName");
const modalClientEmail = document.getElementById("modalClientEmail");
const modalClientMobile = document.getElementById("modalClientMobile");
const modalServiceName = document.getElementById("modalServiceName");

const modalDate = document.getElementById("modalDate");
const modalTime = document.getElementById("modalTime");
const modalDuration = document.getElementById("modalDuration");
const modalStatus = document.getElementById("modalStatus");

detailButtons.forEach((button) => {
    button.addEventListener("click", function () {

        const data = this.dataset;

        console.log(data.appointmentId);
        console.log(data.bookingId);

        modalAppointmentId.textContent = `#${data.appointmentId}`;
        modalBookingId.textContent = `#${data.bookingId}`;

        modalAppointmentIdInput.value = data.appointmentId;
        modalBookingIdInput.value = data.bookingId;

        modalClientName.textContent = data.clientName;
        modalClientEmail.textContent = data.clientEmail;
        modalClientMobile.textContent = data.clientMobile;
        modalServiceName.textContent = data.serviceName;

        modalDate.value = data.date;
        modalTime.value = data.time.substring(0, 5);
        modalDuration.value = data.duration;
        modalStatus.value = data.status;
    });
});