export function generateAvailableSchedule(schedules, bookings) {
    const availableSchedules = [];

    schedules.forEach((schedule) => {
        const hours = [];

        const start = Number(schedule.start_time.split(":")[0]);
        const end = Number(schedule.end_time.split(":")[0]);

        const lunchStart = Number(schedule.start_lunch.split(":")[0]);
        const lunchEnd = Number(schedule.end_lunch.split(":")[0]);

        const scheduleBookings = bookings.filter(
            (booking) => booking.appointment_date === schedule.date,
        );

        for (let hour = start; hour < end; hour++) {
            if (hour >= lunchStart && hour < lunchEnd) {
                continue;
            }

            const hasBooking = scheduleBookings.some(
                (booking) => Number(booking.appointment_time.split(":")[0]) === hour,
            );

            if (hasBooking) {
                continue;
            }

            hours.push(`${String(hour).padStart(2, "0")}:00`);
        }

        availableSchedules.push({
            date: schedule.date,
            hours: hours,
        });
    });

    return availableSchedules;
}
