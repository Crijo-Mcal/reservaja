const paymentDetailModal = document.getElementById("paymentDetailModal");

paymentDetailModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;

    document.getElementById("modalPaymentId").textContent = "#PAY-" + button.dataset.paymentId;

    document.getElementById("modalBookingId").textContent = "#BOOK-" + button.dataset.bookingId;

    document.getElementById("modalClientName").textContent = button.dataset.clientName;

    document.getElementById("modalServiceName").textContent = button.dataset.serviceName;

    document.getElementById("modalPaymentType").textContent = button.dataset.paymentType;

    document.getElementById("modalPaymentMethod").textContent = button.dataset.paymentMethod;

    document.getElementById("modalAmount").textContent = "€" + button.dataset.amount;

    document.getElementById("modalStatus").textContent = button.dataset.status;

    document.getElementById("modalDate").textContent = button.dataset.date;
});
