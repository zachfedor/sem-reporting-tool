/*
    Javascript functions for custom reports pages
 */

function reportsPieChart() {
    var pie_slices = document.querySelectorAll('.rc-pie');
    for (slice in pie_slices) {
        slice.style.opacity = 0.5;
        // document.styleSheets[0].addRule('::before','color: green');
        // document.styleSheets[0].insertRule('.red::before { color: green }', 0);
    }
}