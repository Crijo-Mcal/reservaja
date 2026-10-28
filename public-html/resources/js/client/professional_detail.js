document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('serviceModal');

    if (!modal) {
        return;
    }

    const title = document.getElementById('serviceModalLabel');
    const description = document.getElementById('serviceModalDescription');
    const duration = document.getElementById('serviceModalDuration');
    const price = document.getElementById('serviceModalPrice');
    const vat = document.getElementById('serviceModalVat');
    const advance = document.getElementById('serviceModalAdvance');
    const select = document.getElementById('serviceModalSelect');

    document.querySelectorAll('.service-details').forEach(button => {
        button.addEventListener('click', () => {
            const professionalID = button.dataset.professionalId;
            const serviceId = button.dataset.serviceId;
            const serviceName = button.dataset.serviceName;
            const serviceDescription = button.dataset.serviceDescription;
            const serviceDuration = button.dataset.serviceDuration;
            const servicePrice = parseFloat(button.dataset.servicePrice);
            const serviceVat = parseFloat(button.dataset.serviceVat);
            const serviceAdvance = parseFloat(button.dataset.serviceAdvance);

            const advanceAmount = servicePrice * (serviceAdvance / 100);

            title.textContent = serviceName;

            description.textContent = serviceDescription || 'Informação sobre este serviço não disponível.';

            duration.textContent = `${serviceDuration} minutos`;

            price.textContent = formatCurrency(servicePrice);

            vat.textContent = `${formatNumber(serviceVat)}%`;

            advance.textContent =
                `${formatNumber(serviceAdvance)}% (${formatCurrency(advanceAmount)})`;

            select.href =
                `/reservaja/public/client/booking?service_id=${serviceId}&professional_id=${professionalID}`;
        });
    });

    function formatCurrency(value) {
        return new Intl.NumberFormat('pt-PT', {
            style: 'currency',
            currency: 'EUR'
        }).format(value);
    }

    function formatNumber(value) {
        return new Intl.NumberFormat('pt-PT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }
});