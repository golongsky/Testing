<div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Area Chart</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    var dt_prod_set;
    var dt_nprod_set;

    $.ajax({
        type: "GET",
        url: "chartdata",
        success: function (response) {
          dt_prod_set = response.pdata;
          dt_nprod_set = response.ndata;



          var areaChartData = {
            labels  : [
                        '12 MN', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM', '6 AM',
                        '7 AM', '8 AM', '9 AM', '10 AM', '11 AM', '12 NOON', '1 PM',
                        '2 PM', '3 PM', '3 PM', '5 PM', '6 PM', '7 PM', '8 PM',
                        '9 PM', '10 PM', '11 PM'
                      ],
            datasets: [
              {
                label               : 'Production',
                // backgroundColor     : 'rgba(40,167,69,1)',
                borderColor         : 'rgba(23,162,184,1)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(23,162,184,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(23,162,184,1)',
                data                : dt_prod_set
              },
              {
                label               : 'Non-Production',
                // backgroundColor     : 'rgba(220, 53, 69, 1)',
                borderColor         : 'rgba(220, 53, 69, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(220, 53, 69, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220, 53, 69, 1)',
                data                : dt_nprod_set
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

          new Chart(areaChartCanvas, {
              type: 'line',
              data: areaChartData,
              options: areaChartOptions
          })

          setInterval(function () {
            new Chart(areaChartCanvas, {
              type: 'line',
              data: areaChartData,
              options: areaChartOptions
            })
          }, 60000);

        }
      });
  })
</script>