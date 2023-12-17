// public/js/chart.js
document.addEventListener('DOMContentLoaded', function () {
  // Get data from view
  var axisX = JSON.parse(document.getElementById('chartData').getAttribute('data-axis-x'));
  var axisYs = JSON.parse(document.getElementById('chartData').getAttribute('data-axis-ys'));

  // Rendering a chart using Chart.js
  var ctx = document.getElementById('myChart').getContext('2d');

  var datasets = axisYs.map(function (axisY) {
    return {
      type: axisY.type ? axisY.type : 'bar',
      label: axisY.label,
      data: axisY.data,
      backgroundColor: axisY.backgroundColor ? axisY.backgroundColor : null
    };
  });

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: axisX,
      datasets: datasets
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
});
