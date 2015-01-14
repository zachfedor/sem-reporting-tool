/*
    Javascript functions for custom reports pages
 */

function reportsPieChart() {
    alert('pie chart ran');
    var pie_slices = document.querySelectorAll('.rc-pie');
    for (slice in pie_slices) {
        slice.style.opacity = 0.5;
        // document.styleSheets[0].addRule('::before','color: green');
        // document.styleSheets[0].insertRule('.red::before { color: green }', 0);
    }
}

function reportsChart() {
    alert('charts.js ran');
    var ctx = document.getElementById("myChart").getContext("2d");

    var data = [
        {
            value: 300,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Red"
        },
        {
            value: 50,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Green"
        },
        {
            value: 100,
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Yellow"
        }
    ]

    var myPieChart = new Chart(ctx[0]).Pie(data);
}
