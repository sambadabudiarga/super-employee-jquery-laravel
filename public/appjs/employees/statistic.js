// Chart.defaults.global.legend = {
//     enabled: true
// };

// Line chart
var ctx = document.getElementById("lineChart").getContext('2d');
var Emp_Ages = new Array();
var Emp_Countries = new Array();
var Emp_Datasets = new Array();
var lineChart;

$(function() {
    $.get(urlRoot + '/employees/chart')
     .done(function(data) {
        Emp_Ages = data.emp_ages;
        Emp_Countries = data.emp_countries;
        Emp_Datasets = data.datasets;

        lineChart = new Chart(ctx, {
            type: 'scatter',
            showLine: true,
            data: {
                labels: Emp_Countries,
                datasets: Emp_Datasets,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                },
                spanGaps: true,
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            // console.log('----------', tooltipItem, data);
                            // var label = data.labels[tooltipItem.index];
                            return tooltipItem.datasetIndex + ' (Age ' + tooltipItem.xLabel + ') : ' + tooltipItem.yLabel;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Employee by Country and Age'
                }
            }
        });        
     })
     .fail(function(jqXhr) {
         console.log(jqXhr);
         alert('Failed getting chart data')
     });
});
