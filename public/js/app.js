// Handle window resize for chart
$(window).resize(function() {
    if (typeof financialChart !== 'undefined') {
        financialChart.resize();
    }
});

// Close sidebar when clicking outside on mobile
$(document).click(function(e) {
    if ($(window).width() < 992) {
        if (!$(e.target).closest('#sidebar').length && !$(e.target).is('#mobileSidebarToggle')) {
            $('#sidebar').removeClass('active');
        }
    }
});