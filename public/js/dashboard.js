// Dashboard Chart and Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize monthly chart
    initializeMonthlyChart();
    
    // Initialize search functionality
    initializeSearchFunctionality();
});

function initializeMonthlyChart() {
    const ctx = document.getElementById('monthlyChart');
    if (!ctx) return;
    
    // Get data from data attributes
    const chartContainer = ctx.closest('.chart-container');
    const labels = JSON.parse(chartContainer.dataset.labels || '[]');
    const data = JSON.parse(chartContainer.dataset.values || '[]');
    
    const monthlyChart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: data,
                backgroundColor: [
                    'rgba(108, 117, 125, 0.8)',
                    'rgba(13, 110, 253, 0.8)'
                ],
                borderColor: [
                    'rgba(108, 117, 125, 1)',
                    'rgba(13, 110, 253, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' peminjaman';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return Math.floor(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

function initializeSearchFunctionality() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }
}
