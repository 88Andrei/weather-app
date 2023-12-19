<div class="col-md-12">
  <div class="my-chart">
    <canvas id="myChart"> </canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <div id="chartData"
      {{ $axisX }}
      {{ $axisYs }}
      >
    </div>
  </div>
</div>
