export function generateAvailableSchedule(schedules, bookings, service_duration) {
    const availableSchedules = [];
    const serviceHours = Number(service_duration) / 60;

    schedules.forEach((schedule) => {
        const hours = [];

        const startHour = Number(schedule.start_time.split(":")[0]);
        const endHour = Number(schedule.end_time.split(":")[0]);

        const lunchStart = Number(schedule.start_lunch.split(":")[0]);
        const lunchEnd = Number(schedule.end_lunch.split(":")[0]);

        // Procurar a marcação correspondente à data do horário.
        const booking = bookings.find((booking) => booking.appointment_date === schedule.date,);

        // Criar todos os horários disponíveis.
        for (let hour = startHour; hour < endHour; hour++) {

            // Verificar o período de almoço.
            if (hour >= lunchStart && hour < lunchEnd) {
                continue;
            }

            // Verificar se existe uma marcação neste horário.
            if (booking) {
                const bookingStart = Number(booking.appointment_time.split(":")[0]);

                const bookingDuration = Number(booking.service_duration) / 60;
                const bookingEnd = bookingStart + bookingDuration;

                if (hour >= bookingStart && hour < bookingEnd) {
                    continue;
                }
            }

            hours.push(formatHour(hour));
        }

        // Verificar se o serviço selecionado
        // cabe nos horários disponíveis.
        const verifiedHours = hours.filter((hour) => {
            const startHour = Number(hour.split(":")[0]);

            for (let offset = 0; offset < serviceHours; offset++) {
                const requiredHour = startHour + offset;
                const requiredTime = formatHour(requiredHour);
                if (!hours.includes(requiredTime)) {
                    return false;
                }
            }

            return true;
        });

        availableSchedules.push({
            date: schedule.date,
            hours: verifiedHours,
        });
    });

    return availableSchedules;
}

function formatHour(hour) {
    return `${String(hour).padStart(2, "0")}:00`;
}
