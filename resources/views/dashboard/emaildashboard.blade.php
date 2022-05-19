<div class="row">
    <div class="col-12">
      <!-- jQuery Knob -->
      <div class="card collapsed-card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Email Knobs - Tech
          </h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool btn-email-knobs" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
            <button type="button" class="btn btn-tool">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: none;">
          <div class="row">
            <div class="col-6 col-md-3 text-center">
              <input type="text" class="knob less-4-knob-t" value="30" data-width="90" data-height="90" data-fgColor="#3c8dbc" readonly>

              <div class="knob-label">=< 4 Hours</div>
            </div>
            <!-- ./col -->
            <div class="col-6 col-md-3 text-center">
              <input type="text" class="knob less-8-knob-t" value="70" data-width="90" data-height="90" data-fgColor="#f56954" readonly>

              <div class="knob-label">=< 8 Hours</div>
            </div>
            <!-- ./col -->
            <div class="col-6 col-md-3 text-center">
              <input type="text" class="knob less-12-knob-t" value="-80" data-min="-150" data-max="150" data-width="90"
                     data-height="90" data-fgColor="#00a65a" readonly>

              <div class="knob-label">=< 12 Hours</div>
            </div>
            <!-- ./col -->
            <div class="col-6 col-md-3 text-center">
              <input type="text" class="knob less-24-knob-t" value="40" data-width="90" data-height="90" data-fgColor="#00c0ef" readonly>

              <div class="knob-label">< = 24 Hours</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <div class="col-6 col-md-4 text-center">
              <input type="text" class="knob new-knob-t" value="90" data-width="90" data-height="90" data-fgColor="#932ab6" readonly>

              <div class="knob-label">New Tickets</div>
            </div>
            <!-- ./col -->
            <div class="col-6 col-md-4 text-center">
              <input type="text" class="knob more-24-knob-t" value="90" data-width="90" data-height="90" data-fgColor="#932ab6" readonly>

              <div class="knob-label">> 24 Hours</div>
            </div>
            <!-- ./col -->
            <div class="col-6 col-md-4 text-center">
              <input type="text" class="knob open-knob-t" value="50" data-width="90" data-height="90" data-fgColor="#39CCCC" readonly>

              <div class="knob-label">Open Tickets</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
  <div class="col-12">
    <!-- jQuery Knob -->
    <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Email Knobs - Non Tech
        </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool btn-email-knobs" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
          <button type="button" class="btn btn-tool">
            <i class="fas fa-eye"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body" style="display: none;">
        <div class="row">
          <div class="col-6 col-md-3 text-center">
            <input type="text" class="knob less-4-knob-nt" value="30" data-width="90" data-height="90" data-fgColor="#3c8dbc" readonly>

            <div class="knob-label">=< 4 Hours</div>
          </div>
          <!-- ./col -->
          <div class="col-6 col-md-3 text-center">
            <input type="text" class="knob less-8-knob-nt" value="70" data-width="90" data-height="90" data-fgColor="#f56954" readonly>

            <div class="knob-label">=< 8 Hours</div>
          </div>
          <!-- ./col -->
          <div class="col-6 col-md-3 text-center">
            <input type="text" class="knob less-12-knob-nt" value="-80" data-min="-150" data-max="150" data-width="90"
                   data-height="90" data-fgColor="#00a65a" readonly>

            <div class="knob-label">=< 12 Hours</div>
          </div>
          <!-- ./col -->
          <div class="col-6 col-md-3 text-center">
            <input type="text" class="knob less-24-knob-nt" value="40" data-width="90" data-height="90" data-fgColor="#00c0ef" readonly>

            <div class="knob-label">< = 24 Hours</div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-6 col-md-4 text-center">
            <input type="text" class="knob new-knob-nt" value="90" data-width="90" data-height="90" data-fgColor="#932ab6" readonly>

            <div class="knob-label">New Tickets</div>
          </div>
          <!-- ./col -->
          <div class="col-6 col-md-4 text-center">
            <input type="text" class="knob more-24-knob-nt" value="90" data-width="90" data-height="90" data-fgColor="#932ab6" readonly>

            <div class="knob-label">>24 Hours</div>
          </div>
          <!-- ./col -->
          <div class="col-6 col-md-4 text-center">
            <input type="text" class="knob open-knob-nt" value="50" data-width="90" data-height="90" data-fgColor="#39CCCC" readonly>

            <div class="knob-label">Open Tickets</div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
  
  <script>
    $(function () {
      $('.btn-email-knobs').click(function (e) { 
        loadKnobs();
      });


      function loadKnobs(){
        anm();
        $.ajax({
          method: "GET",
          url: 'loadknobs',
          success: function(response){
            console.log(response);
            $('.less-4-knob-t').val(response.l4t);
            $('.less-8-knob-t').val(response.l8t);
            $('.less-12-knob-t').val(response.l12t);
            $('.less-24-knob-t').val(response.l24t);
            $('.more-24-knob-t').val(response.m24t);
            $('.new-knob-t').val(response.techNew);
            $('.open-knob-t').val(response.techOpen);

            $('.less-4-knob-nt').val(response.l4nt);
            $('.less-8-knob-nt').val(response.l8nt);
            $('.less-12-knob-nt').val(response.l12nt);
            $('.less-24-knob-nt').val(response.l24nt);
            $('.more-24-knob-nt').val(response.m24nt);
            $('.new-knob-nt').val(response.nontechNew);
            $('.open-knob-nt').val(response.nontechOpen);
          }
        });
      }
      
    })

    function anm(){
      $('.knob').knob({
        readOnly: true,
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function () {
  
          // "tron" case
          if (this.$.data('skin') == 'tron') {
  
            var a   = this.angle(this.cv)  // Angle
              ,
                sa  = this.startAngle          // Previous start angle
              ,
                sat = this.startAngle         // Start angle
              ,
                ea                            // Previous end angle
              ,
                eat = sat + a                 // End angle
              ,
                r   = true
  
            this.g.lineWidth = this.lineWidth
  
            this.o.cursor
            && (sat = eat - 0.3)
            && (eat = eat + 0.3)
  
            if (this.o.displayPrevious) {
              ea = this.startAngle + this.angle(this.value)
              this.o.cursor
              && (sa = ea - 0.3)
              && (ea = ea + 0.3)
              this.g.beginPath()
              this.g.strokeStyle = this.previousColor
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
              this.g.stroke()
            }
  
            this.g.beginPath()
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
            this.g.stroke()
  
            this.g.lineWidth = 2
            this.g.beginPath()
            this.g.strokeStyle = this.o.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
            this.g.stroke()
  
            return false
          }
        }
      }).children().off('mousewheel DOMMouseScroll');
    }
  
  </script>