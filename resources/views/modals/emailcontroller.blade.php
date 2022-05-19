<div class="modal fade" id="modal-lg-email">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Email Controller for Ticket No. - <label class="ticket-number">006906479</label></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                            <div class="row">
                                <div class="col-md-12" style="
                                padding: 5px 25px 10px 25px;
                            ">
                                    <div style="
                                        font-size: 55px;
                                        padding: 0px 0px 0px;
                                        text-align: center;
                                        background-color: #dfdfdf;
                                    " id="email-time">
                                        00:00:00
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="email-comment">
                                <div class="col-md-12" style="
                                padding: 0px 25px 0px 25px;
                            ">
                                    {{-- <button id="email-go" class="btn btn-danger form-control">Stop</button> --}}
                                    <input type="button" value="Start" id="email-go" disabled style="width: 100%"/>
                                    <input type="button" value="Reset" id="email-rst" disabled style="display: none"/>
                                </div>
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
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<script>
    var timertat = '',
        startetime = '',
        endetime   = '';
    var sw = {
        // (A) INITIALIZE
        etime : null, // HTML time display
        erst : null, // HTML reset button
        ego : null, // HTML start/stop button
        ecom: null,
        etimestart: null,
        etimeend: null,
        init : function () {
            // (A1) GET HTML ELEMENTS
            sw.etime = document.getElementById("email-time");
            sw.erst = document.getElementById("email-rst");
            sw.ego = document.getElementById("email-go");
            sw.ecom = document.getElementById("commentEmail");

            // (A2) ENABLE BUTTON CONTROLS
            sw.erst.addEventListener("click", sw.reset);
            sw.erst.disabled = false;
            sw.ego.addEventListener("click", sw.start);
            sw.ego.disabled = false;
        },

        // (B) TIMER ACTION
        timer : null, // timer object
        now : 0, // current elapsed time
        tick : function () {
            // (B1) CALCULATE HOURS, MINS, SECONDS
            sw.now++;
            var remain = sw.now;
            var hours = Math.floor(remain / 3600);
            remain -= hours * 3600;
            var mins = Math.floor(remain / 60);
            remain -= mins * 60;
            var secs = remain;

            // (B2) UPDATE THE DISPLAY TIMER
            if (hours<10) { hours = "0" + hours; }
            if (mins<10) { mins = "0" + mins; }
            if (secs<10) { secs = "0" + secs; }
            sw.etime.innerHTML = hours + ":" + mins + ":" + secs;
        },
    
        // (C) START!
        start : function () {
            sw.timer = setInterval(sw.tick, 1000);
            sw.ego.value = "Stop";
            sw.ego.removeEventListener("click", sw.start);
            sw.ego.addEventListener("click", sw.stop);

            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            startetime = date+' '+time;
        },

        // (D) STOP
        stop  : function () {
            if (sw.ecom.value != "") {
                if ($('.trans-tp').val() != 0){

                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    endetime = date+' '+time;

                    //Store all Variables Here first
                    console.log(sw.etime.innerHTML);
                    console.log($('.trans-tp').val());
                    console.log(sw.ecom.value);
                    console.log(startetime);
                    console.log(endetime);

                    $.ajax({
                        type: "POST",
                        url: "email-trnx-save",
                        data: {
                            "trans_type"     : 'Email Support',
                            "trans_tat"      : sw.etime.innerHTML,
                            "trans_rem"      : sw.ecom.value,
                            "trans_str"      : startetime,
                            "trans_end"      : endetime,
                            // Insert Email here / above is for transaction
                            "email_state"    : $('#ticketState').val(),
                            "email_concern"  : $('#concern').val(),
                            "email_sub"      : $('#subconcern').val(),
                            "email_remarks"  : $('#commentEmail').val(), 
                            "email_ticket_no": $('.ticket-number').html(),
                            _token: $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json",
                        success: function (response) {
                            $('#concern').attr('disabled', true);
                            $('#subconcern').attr('disabled', true);
                            $('#ticketState').attr('disabled', true);
                            $('#email-comment').attr('disabled', true);
                            console.log(response);


                            clearInterval(sw.timer);
                            sw.timer = null;
                            sw.ego.value = "Start";
                            sw.ego.removeEventListener("click", sw.stop);
                            sw.ego.addEventListener("click", sw.start);

                            if (sw.timer != null) { sw.stop(); }
                            sw.now = -1;
                            sw.tick();

                            $("#modal-lg-email").modal('hide');
                        }
                    });

                    
                }
            }else{
                alert("Comment and/or Transaction Type is Missing!");
            }
        },

        // (E) RESET
        reset : function () {
            if (sw.timer != null) { sw.stop(); }
            sw.now = -1;
            sw.tick();
        }
    };

    window.addEventListener("load", sw.init);
    
</script>