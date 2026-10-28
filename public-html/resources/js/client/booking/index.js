const availableData = Array.isArray(dataBase.available_data)
    ? dataBase.available_data
    : [];

const bookingDate = document.querySelector("#bookingDate");
const bookingHours = document.querySelector("#bookingHours");
const appointmentTime = document.querySelector("#appointmentTime");
const bookingForm = document.querySelector("#bookingForm");

function formatDate(date) {
    const [year, month, day] = date.split("-");

    return `${day}/${month}/${year}`;
}

function renderAvailableDates() {
    bookingDate.innerHTML = `
        <option value="">Selecionar data</option>
    `;

    availableData.forEach((data) => {
        if (!data.date) {
            return;
        }

        const option = document.createElement("option");

        option.value = data.date;
        option.textContent = formatDate(data.date);

        bookingDate.appendChild(option);
    });
}

function renderAvailableHours(date) {
    bookingHours.innerHTML = "";
    appointmentTime.value = "";

    if (!date) {
        bookingHours.innerHTML = `
            <div class="text-secondary small">
                Selecione primeiro uma data.
            </div>
        `;

        return;
    }

    const selectedDate = availableData.find(
        (data) => String(data.date) === String(date)
    );

    if (!selectedDate) {
        bookingHours.innerHTML = `
            <div class="text-secondary small">
                Não existem horários disponíveis para esta data.
            </div>
        `;

        return;
    }

    const availableHours = Array.isArray(selectedDate.available_hours)
        ? selectedDate.available_hours
        : [];

    if (availableHours.length === 0) {
        bookingHours.innerHTML = `
            <div class="text-secondary small">
                Não existem horários disponíveis para esta data.
            </div>
        `;

        return;
    }

    availableHours.forEach((hour) => {
        const hourElement = document.createElement("div");

        hourElement.classList.add("booking-hour");
        hourElement.textContent = hour;

        hourElement.addEventListener("click", () => {
            document
                .querySelectorAll(".booking-hour")
                .forEach((element) => {
                    element.classList.remove("active");
                });

            hourElement.classList.add("active");
            appointmentTime.value = hour;
        });

        bookingHours.appendChild(hourElement);
    });
}

bookingDate.addEventListener("change", () => {
    renderAvailableHours(bookingDate.value);
});

bookingForm.addEventListener("submit", (event) => {
    if (!bookingDate.value) {
        event.preventDefault();

        alert("Selecione uma data.");
        bookingDate.focus();

        return;
    }

    if (!appointmentTime.value) {
        event.preventDefault();

        alert("Selecione uma hora.");
        return;
    }
});

renderAvailableDates();