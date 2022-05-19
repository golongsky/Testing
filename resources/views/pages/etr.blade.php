<div class="content-wrapper" style="min-height: 480px !important">
    <section class="content" style="margin-top: 5px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      @if(Auth::user()->access_level == 2)
                        <table style="width: 100%">
                          <tr>
                            <td>
                              <button class="btn btn-block btn-primary tracker-window">Open Tracker</button>
                            </td>
                            @if(Auth::user()->is_email == 1)
                              <td style="width: 1%;background-color: orange; margin-left: 5px;">
                                <a class="btn btn-open-mylist" href="javascript:void(0)">
                                  <i class="fa-archive fas" style="font-weight: bolder;color: #fff;"></i>
                                </a>
                                <a class="btn btn-open-emaillist" href="javascript:void(0)" style="display: none">
                                  <i class="fa-arrow-left fas" style="font-weight: bolder;color: #fff;"></i>
                                </a>
                              </td>
                            @endif
                          </tr>
                        </table>
                      @else
                      <table style="width: 100%">
                        <tr>
                          <td><input type="date" class="form-control etr-filter ts-start" max="<?= date('Y-m-d'); ?>"></td>
                          <td><input type="date" class="form-control etr-filter ts-end" max="<?= date('Y-m-d'); ?>"></td>
                          <td style="width: 1%;background-color: green;">
                            <a class="btn btn-refresh-tbl">
                              <i class="fa-recycle fas" style="font-weight: bolder;color: #fff;"></i>
                            </a>
                          </td>
                          <td style="width: 1%;background-color: orange; margin-left: 5px;">
                            <a class="btn btn-open-mylist" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Email Tickets">
                              <i class="fa-archive fas" style="font-weight: bolder;color: #fff;"></i>
                            </a>
                            <a class="btn btn-open-emaillist" href="javascript:void(0)" style="display: none">
                              <i class="fa-arrow-left fas" style="font-weight: bolder;color: #fff;"></i>
                            </a>
                          </td>
                          <td style="width: 1%;background-color: red; margin-left: 5px; display: none" class="upload-td">
                            <a class="btn btn-upload-email" href="javascript:void(0)" data-toggle="modal" data-target=".modal-upload">
                              <i class="fa-upload fas" style="font-weight: bolder;color: #fff;"></i>
                            </a>
                          <td style="width: 1%;background-color: rgb(255, 102, 0); margin-left: 5px; display: none" class="upload-td">
                              <a class="btn btn-delete-record" href="javascript:void(0)" target-value="">
                                <i class="fa-eraser fas" style="font-weight: bolder;color: #fff;"></i>
                              </a>
                          </td>
                        </tr>
                      </table>
                        
                        
                      @endif
                    </div>
                    <div class="card-body email-card-body" style="display: none">
                      <table id="emailTable" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Ticket Code</th>
                            <th>Age</th>
                            <th>Create</th>
                            <th>Close</th>
                            <th>State</th>
                            <th>Queue</th>
                            @if(Auth::user()->access_level != 2)
                              <th>Agent</th>
                              <th>New State</th>
                              <th>Concern</th>
                              <th>Sub Concern</th>
                              <th>Controls</th>
                            @endif
                          </tr>
                        </thead>
                        <tbody class="tbody-email"></tbody>
                      </table>
                      @if(Auth::user()->access_level == 2)
                        <div class="row" style="margin-top: 25px">
                          <div class="col-12">
                            <div class="card card-warning card-outline card-tabs">
                              <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                  <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="" id="ticketState" class="form-control">
                                                <option value="0" selected>Ticket State</option>
                                                <option value="Closed">Closed</option>
                                                <option value="Open">Open</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Unworkable">Unworkable</option>
                
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="" id="concern" class="form-control">
                                                <option value="">Concern Type</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="" id="subconcern" class="form-control">
                                                <option value="">Sub Concern Type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-6">
                                            <textarea name="" id="commentEmail" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                          <div id="timer" style="padding: 5px 25px 10px 25px;text-align: center;">
                                            <span id="minutes" style="font-size: 55px">00</span>:<span style="font-size: 55px" id="seconds">00</span>
                                          </div>
                                          <div id="control">
                                            <button id="startbtn" class="btn btn-success" style="width: 100%;">START</button>
                                            <button id="resetbtn" class="btn btn-danger" style="width: 100%;display: none">STOP</button>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.card -->
                            </div>
                          </div>
                        </div>
                      @endif
                    </div>


                    <div class="card-body main-card-body">
                      <input class="last-id" style="display: none"/>
                      <table id="etrTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Tranx Id</th>
                          @if(Auth::user()->access_level != 2)
                            <th>Agent</th>
                          @endif
                          <th>Tranx Code</th>
                          <th>Details</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>TAT</th>
                          <th>Remarks</th>
                          @if(Auth::user()->access_level != 2)
                            <th>Group</th>
                            <th>SubGroup</th>
                          @endif
                            <th>New State</th>
                            <th>Concern</th>
                            <th>Sub Concern</th>
                        </tr>
                        </thead>
                        <tbody class="tbody-mtrx">
                          
                        
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Tranx Id</th>
                          @if(Auth::user()->access_level != 2)
                            <th>Agentode</th>
                          @endif
                          <th>Tranx Code</th>
                          <th>Details</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>TAT</th>
                          <th>Remarks</th>
                          @if(Auth::user()->access_level != 2)
                            <th>Group</th>
                            <th>SubGroup</th>
                          @endif
                            <th>New State</th>
                            <th>Concern</th>
                            <th>Sub Concern</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
<script src="{{ asset('js/mytrx.js') }}" defer></script>
<style>
  td{
    width: 160px;
    height: 15px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }
</style>
<script>

  if ($('.active-access-id').val() == 2) {
    var timertat = '',
      startetime = '',
      endetime   = '',
      ecom       = '',
      estate     = '',
      econcern   = '',
      esub       = '',
      eticketno  = '';
    var Clock = {
    totalSeconds: 0,
    startTimer: function () {

      $.ajax({
        type: "POST",
        url: "stp",
        data: {"email_ticket_no": $('.copy_text').html(),
              _token: $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        success: function (response) {
          
        }
      });

      
      if (!this.interval) {
          var self = this;
          function pad(val) { return val > 9 ? val : "0" + val; }
          this.interval = setInterval(function () {
            self.totalSeconds += 1;
            document.getElementById("minutes").innerHTML = pad(Math.floor(self.totalSeconds / 60 % 60));
            document.getElementById("seconds").innerHTML = pad(parseInt(self.totalSeconds % 60));
          }, 1000);
        document.getElementById("startbtn").style.display = "none";
        document.getElementById("resetbtn").style.display = "block";

        var today = new Date(),
            date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate(),
            time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        startetime = date+' '+time;
      }
    },
    resetTimer: function () {

      if ($('#ticketState').val() == 0) {
        toastr.error('Please Select Ticket State.');
        return false;
      }

      if ($('#concern').val() == 0) {
        toastr.error('Please Select Concern.');
        return false;
      }

      if ($('#subconcern').val() == 0) {
        toastr.error('Please Select Sub Concern.');
        return false;
      }

      if ($('#commentEmail').val() == "") {
        toastr.error('Please Input Comment.');
        return false;
      }

      document.getElementById("startbtn").style.display = "block";
      document.getElementById("resetbtn").style.display = "none";


      var today = new Date(),
          date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate(),
          time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
          endetime = date+' '+time;

          timertat = "00:"+document.getElementById("minutes").innerHTML+":"+document.getElementById("seconds").innerHTML;

          const difference = moment(endetime, "YYYY/MM/dd HH:mm:ss").diff(moment(startetime, "YYYY/MM/dd HH:mm:ss"))
          const diff = moment.utc(difference).format("HH:mm:ss");

      $.ajax({
          type: "POST",
          url: "email-trnx-save",
          data: {
              "trans_type"     : 'Email Support',
              "trans_tat"      : diff,
              "trans_rem"      : $('#commentEmail').val(),
              "trans_str"      : startetime,
              "trans_end"      : endetime,
              // Insert Email here / above is for transaction
              "email_state"    : $('#ticketState').val(),
              "email_concern"  : $('#concern').val(),
              "email_sub"      : $('#subconcern').val(),
              "email_remarks"  : $('#commentEmail').val(), 
              "email_ticket_no": $('.copy_text').html(),
              _token: $('meta[name="csrf-token"]').attr('content')},
          dataType: "json",
          success: function (response) {
              console.log(response);
              $('#concern').val(0);
              htmlcontrol( $('#subconcern'), "<option value='0'>Sub Concern Type</option>" );
              $('#ticketState').val(0);
              $('#commentEmail').val("");
              $('.tbody-email')
                .empty()
                .append(
                  "<tr class='empty-handler'>"+
                    "<td colspan='6' style='text-align: center; font-weight: bold;''>Pulling New Ticket. Please Wait!</td>"+
                  "</tr>"
                );
                document.getElementById("startbtn").style.display = "none";
                loadEmailList(1);
                document.getElementById("startbtn").style.display = "block";
          }
      });
        
        
        Clock.totalSeconds = null; 
        clearInterval(this.interval);
        document.getElementById("minutes").innerHTML = "00";
        document.getElementById("seconds").innerHTML = "00";
        delete this.interval;
        
    },
  };

  document.getElementById("startbtn").addEventListener("click", function () { Clock.startTimer(); });
  document.getElementById("resetbtn").addEventListener("click", function () { Clock.resetTimer(); });
  }
  
</script>