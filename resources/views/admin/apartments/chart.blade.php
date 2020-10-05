@extends('layouts.app')
@section('content')
  {{-- script per chart --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <div class="container">
    <div class="row">
      <div class="col-6">
        <canvas id="myChart" width="400" height="400"></canvas>

        <script>
        var array_dates = <?php echo $array_dates; ?>;
        var array_views = <?php echo $array_views; ?>;

        console.log(array_dates);
        console.log(array_views);
          var ctx = document.getElementById('myChart').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: array_dates,
              datasets: [{
                label: '# numero di visualizzazioni',
                data: array_views,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          });
        </script>
      </div>


      {{-- grafico messaggi --}}

      <div class="col-6">
        <canvas id="myChartMessage" width="400" height="400"></canvas>

        <script>
        var array_dates_message = <?php echo $array_dates_message; ?>;
        var array_counts_message = <?php echo $array_counts_message; ?>;

        console.log(array_dates_message);
        console.log(array_counts_message);

          var ctx = document.getElementById('myChartMessage').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: array_dates_message,
              datasets: [{
                label: '# numero di messaggi ricevuti',
                data: array_counts_message,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          });
        </script>
      </div>

    </div>

  </div>


@endsection
