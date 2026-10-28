document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('ratingModal');

    if (!modalElement) {
        return;
    }

    const starsContainer = modalElement.querySelector(
        '[data-rating-stars]'
    );

    const ratingInput = modalElement.querySelector(
        '[data-rating-input]'
    );

    const ratingText = modalElement.querySelector(
        '[data-rating-text]'
    );

    const submitButton = modalElement.querySelector(
        '[data-submit-rating]'
    );

    const ratingLabels = {
        1: 'Muito insatisfeito',
        2: 'Insatisfeito',
        3: 'Razoável',
        4: 'Satisfeito',
        5: 'Muito satisfeito'
    };

    const starSvg = `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round">

            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>

        </svg>
    `;

    for (let rating = 1; rating <= 5; rating++) {

        const star = document.createElement('button');

        star.type = 'button';
        star.className = 'rating-star';
        star.dataset.rating = rating;
        star.setAttribute(
            'aria-label',
            `${rating} estrelas`
        );

        star.innerHTML = starSvg;

        starsContainer.appendChild(star);
    }

    const stars = starsContainer.querySelectorAll(
        '.rating-star'
    );

    stars.forEach(function (star) {

        star.addEventListener('click', function () {

            const selectedRating = Number(
                this.dataset.rating
            );

            ratingInput.value = selectedRating;

            stars.forEach(function (item) {

                item.classList.toggle(
                    'active',
                    Number(item.dataset.rating) <= selectedRating
                );

            });

            ratingText.textContent =
                ratingLabels[selectedRating];

            submitButton.disabled = false;

        });

    });

    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });

    modal.show();

});