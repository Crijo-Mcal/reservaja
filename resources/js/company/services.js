document.addEventListener('DOMContentLoaded', function () {

    const editButtons = document.querySelectorAll('.edit-service');

    editButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            document.getElementById('serviceId').value =
                button.dataset.id;

            document.getElementById('serviceName').value =
                button.dataset.name;

            document.getElementById('serviceStatus').value =
                button.dataset.status;

            document.getElementById('serviceDuration').value =
                button.dataset.duration;

            document.getElementById('servicePrice').value =
                button.dataset.price;

            document.getElementById('serviceVat').value =
                button.dataset.vat;

            document.getElementById('serviceAdvancePayment').value =
                button.dataset.advancePayment;

            document.getElementById('serviceDescription').value =
                button.dataset.description;

        });

    });

});


