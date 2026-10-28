/* DOM */
const calendarMonth = document.getElementById('calendarMonth');
const calendarYear = document.getElementById('calendarYear');
const calendarDays = document.getElementById('calendarDays');
const previousMonth = document.getElementById('previousMonth');
const nextMonth = document.getElementById('nextMonth');
const todayButton = document.getElementById('todayButton');
const selectedSchedules = document.getElementById('selectedSchedules');

const monthNames = [
    'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
];

/* State */
const today = new Date();
let startDate = new Date(today.getFullYear(), today.getMonth(), 1);
let currentDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
let selectedDate = null;
let selectedDates = [];



/* helper */
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function isToday(date) {
    return formatDate(date) === formatDate(today);
}

function fillEditScheduleModal(schedule) {
    document.getElementById('editScheduleId').value = schedule.id;
    document.getElementById('deleteScheduleId').value = schedule.id;
    document.getElementById('editScheduleDate').value = schedule.date;
    document.getElementById('editScheduleStart').value = schedule.start_time;
    document.getElementById('editScheduleEnd').value = schedule.end_time;
    document.getElementById('editScheduleLunchStart').value = schedule.start_lunch;
    document.getElementById('editScheduleLunchEnd').value = schedule.end_lunch;
}

/* Render calendar */
function renderCalendar() {
    const year = startDate.getFullYear();
    const month = startDate.getMonth();


    /* add  yaer an month in header */
    calendarMonth.textContent = monthNames[month];
    calendarYear.textContent = year;

    calendarDays.innerHTML = '';

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    let startDay = firstDay.getDay();
    startDay = startDay === 0 ? 6 : startDay - 1;

    for (let i = 0; i < startDay; i++) {
        const emptyDay = document.createElement('div');

        emptyDay.className = 'calendar-day empty';

        calendarDays.appendChild(emptyDay);
    }

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const date = new Date(year, month, day);
        const dateKey = formatDate(date);
        const existingSchedule = databaseSchedules.find(schedule => schedule.date === dateKey);

        const dayElement = document.createElement('div');

        dayElement.className = 'calendar-day';

        if (isToday(date)) {
            dayElement.classList.add('today');
        }

        if (existingSchedule) {
            dayElement.classList.add('has-schedule');
        }

        if (selectedDates.includes(dateKey)) {
            dayElement.classList.add('selected');
        }

        if (selectedDate === dateKey) {
            dayElement.classList.add('selected');
        }

        dayElement.innerHTML = `
            <div class="calendar-day-number">
                ${day}
            </div>
        `;

        dayElement.addEventListener('click', () => {
            /* model for update schedule in database */
            if (existingSchedule) {
                fillEditScheduleModal(existingSchedule);

                const modal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('editScheduleModal')
                );

                modal.show();
                return;
            }

            /* add new schedule in database */
            if (!selectedDates.includes(dateKey) && formatDate(currentDate) <= dateKey) {
                selectedDates.push(dateKey);
            } else {
                selectedDates = selectedDates.filter(
                    date => date !== dateKey
                );
            }

            renderCalendar();
            renderSelectedSchedules();

            console.log(selectedDates);
        });

        calendarDays.appendChild(dayElement);
    }
}

/* Render selected schedules */
function renderSelectedSchedules() {
    selectedSchedules.innerHTML = '';

    selectedDates.forEach(dateKey => {
        selectedSchedules.innerHTML += `
        <div class="border rounded-3 p-3 cs-fadeIn-y">


            <div class="row g-3 align-items-end">

                <div class="col-12 col-lg-3">
                    <label class="form-label small text-muted mb-1">
                        Data
                    </label>

                    <input
                        type="date"
                         readonly
                        class="form-control form-control-sm"
                        name="date[]"
                        value="${dateKey}">
                </div>

                <div class="col-6 col-lg-2">
                    <label class="form-label small text-muted mb-1">
                        Início
                    </label>

                    <input
                        type="time"
                        class="form-control form-control-sm"
                        name="start_time[]"
                        value="09:00">
                </div>

                <div class="col-6 col-lg-2">
                    <label class="form-label small text-muted mb-1">
                        Fim
                    </label>

                    <input
                        type="time"
                        class="form-control form-control-sm"
                        name="end_time[]"
                        value="18:00">
                </div>

                <div class="col-6 col-lg-2">
                    <label class="form-label small text-muted mb-1">
                        Início almoço
                    </label>

                    <input
                        type="time"
                        class="form-control form-control-sm"
                        name="start_lunch[]"
                        value="12:00">
                </div>

                <div class="col-6 col-lg-2">
                    <label class="form-label small text-muted mb-1">
                        Fim almoço
                    </label>

                    <input
                        type="time"
                        class="form-control form-control-sm"
                        name="end_lunch[]"
                        value="13:00">
                </div>

                <div class="col-12 col-lg-1">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger w-100 buttomDeleteSelection"
                        data-date="${dateKey}">
                        Eliminar
                    </button>
                </div>

            </div>
        </div>
    `;
    });

    const buttons = selectedSchedules.querySelectorAll(
        '.buttomDeleteSelection'
    );

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const dateKey = button.dataset.date;

            selectedDates = selectedDates.filter(
                date => date !== dateKey
            );

            renderCalendar();
            renderSelectedSchedules();
        });
    });
}

/* Calendar navigation */
previousMonth.addEventListener('click', () => {
    startDate.setMonth(startDate.getMonth() - 1);
    renderCalendar();
});

console.log('today:', today);
console.log('today month:', today.getMonth());
console.log('startDate:', startDate);
console.log('startDate month:', startDate.getMonth());

nextMonth.addEventListener('click', () => {
    console.log('BEFORE:', startDate.getMonth());

    startDate.setMonth(startDate.getMonth() + 1);

    console.log('AFTER:', startDate.getMonth());

    renderCalendar();
});

todayButton.addEventListener('click', () => {
    startDate = new Date(
        today.getFullYear(),
        today.getMonth(),
        1
    );

    selectedDate = formatDate(today);

    renderCalendar();
});

/* startDate render */
renderCalendar();
renderSelectedSchedules();