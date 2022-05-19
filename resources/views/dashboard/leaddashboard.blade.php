<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Prod / Non Prod Chart per agent</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-production-knobs" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<script>
    $(function () {
      
      var dt_prod_set;
      var dt_nprod_set;

      $.ajax({
        type: "GET",
        url: "tldata",
        success: function (response) {
        var areaChartData = {
        labels  : response.myagents,
        datasets: [
          {
            label               : 'Non - Production',
            backgroundColor     : 'rgba(220,53,69,1)',
            borderColor         : 'rgba(220,53,69,1)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(220,53,69,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,53,69,1)',
            data                : response.ag_nprod
          },
          {
            label               : 'Production',
            backgroundColor     : 'rgba(255, 193, 7, 1)',
            borderColor         : 'rgba(255, 193, 7, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(220,53,69,1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,53,69,1)',
            data                : response.ag_prod
          },
        ]
      }
  
      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }
  
      //-------------
      //- BAR CHART -
      //-------------
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0
  
      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }
  
  
      //---------------------
      //- STACKED BAR CHART -
      //---------------------
      var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
      var stackedBarChartData = $.extend(true, {}, barChartData)
  
      var stackedBarChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
  
      new Chart(stackedBarChartCanvas, {
        type: 'bar',
        data: stackedBarChartData,
        options: stackedBarChartOptions
      })
        }
      });

      
    })
  </script>