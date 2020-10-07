@extends('layouts.app')
@section('content')
  {{-- script per chart --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <div class="container" id="ms_chart">
    <h1 class="mt-4">Statistiche {{$apartment->title}}</h1>
    <div class="row">
      <div class="col-12 ms_views">
        <h3 class="mt-4 mb-4">Visualizzazioni totali: {{$total_views}}</h3>

        <canvas id="myChart"></canvas>

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
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks:{
                    min: 0,
                    stepSize: 1,
                    fontSize: 15,

                  }
                }],
                xAxes: [{
                  ticks:{
                    fontSize: 20,
                  },
                }]
              }

            }
          });
        </script>
      </div>


      {{-- grafico messaggi --}}

      <div class="col-12 ms_messages">
        <h3 class="mt-4 mb-4">Messaggi Ricevuti: {{$total_messages}}</h3>
        <canvas id="myChartMessage"></canvas>

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
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks:{
                    min: 0,
                    stepSize: 1,
                    fontSize: 15,
                  }
                }],
                xAxes: [{
                  ticks:{
                    fontSize: 20,

                  },
                }]
              }
            }
          });
        </script>
      </div>

    </div>

  </div>


@endsection
