@extends('layouts.app')
@section('content')
  {{-- script per chart --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <div class="container">
    <div class="row">
      <div class="col-6">
        <canvas id="myChart" width="400" height="400"></canvas>

        <script>

          var array_d=[];

          for (var i = 0; i < {{count($array_dates)}}; i++) {

            array_d.push({{$array_dates[i]}});

          }

          console.log(array_d);

          var ctx = document.getElementById('myChart').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: array_dates,
              datasets: [{
                label: '# of Votes',
                data: [1,2,3,4,5,6],
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
