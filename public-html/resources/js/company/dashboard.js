/* line chart */
const lineChart_ctx = document.getElementById("lineChart");

const lineChart_labels = Object.entries(lineChart_value).map((value) => value[0]);

const lineChart_data = {
    labels: lineChart_labels,

    datasets: [
        {
            label: "Revenue",

            data: Object.entries(lineChart_value).map((value) => value[1]),

            fill: false,

            borderColor: "rgb(75, 192, 192)",

            tension: 0.1,
        },
    ],
};

new Chart(lineChart_ctx, {
    type: "line",

    data: lineChart_data,

    options: {
        responsive: true,

        maintainAspectRatio: false,

        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

/* doughnut chart */
const doughnut_ctx = document.getElementById("doughnut");

const doughnut_data = {
    labels: Object.entries(doughnut_value).map((value) => value[0]),

    datasets: [
        {
            label: "Payment Status",

            data: Object.entries(doughnut_value).map((value) => value[1]),

            backgroundColor: ["#10B981", "#F59E0B", "#8B5CF6"],

            borderWidth: 0,
        },
    ],
};

new Chart(doughnut_ctx, {
    type: "doughnut",

    data: doughnut_data,

    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: "65%",

        animation: {
            duration: 2000,
            animateRotate: true,
            easing: "easeOutQuart",
        },

        plugins: {
            legend: {
                display: true,
                position: "bottom",

                labels: {
                    usePointStyle: true,
                    pointStyle: "circle",
                    pointStyleWidth: 19,
                    padding: 20,
                },
            },
        },
    },
});
