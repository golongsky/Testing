<div class="modal fade" id="modal-lg-team-ticket">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="form-list-title">Activity Window</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <table id="activityTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td style="text-align: center">ACTIVE USER</td>
                                <td style="text-align: center">TOTAL TICKETS</td>
                                <td style="text-align: center">WAITING</td>
                                <td style="text-align: center">PROCESSING</td>
                                <td style="text-align: center">CLOSED</td>
                                <td style="text-align: center">PAUSED</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center"><label class="activelog">0</label></td>
                                <td style="text-align: center"><label class="totaltix">0</label></td>
                                <td style="text-align: center"><label class="waiting">0</label></td>
                                <td style="text-align: center"><label class="processing">0</label></td>
                                <td style="text-align: center"><label class="closed">0</label></td>
                                <td style="text-align: center"><label class="paused">0</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table id="activityDetails" class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <td style="text-align: center">TICKET #</td>
                            <td style="text-align: center">AGENT NAME</td>
                            <td style="text-align: center">FULL NAME</td>
                            <td style="text-align: center">SPECIFICATION</td>
                            <td style="text-align: center">STATUS</td>
                            <td style="text-align: center">DURATION</td>
                            <td style="text-align: center">RELEASE</td>
                        </tr>
                    </thead>
                    <tbody id="activeDBody">
                    </tbody>
                </table>
                <i style="color: red">Table Refreshes Every 10 seconds.</i>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#activityDetails').DataTable({pageLength : 5, "bLengthChange": false});
        $("#activityDetails").DataTable().draw();
        
        setInterval(function(){ 
            topTableDetails();
            
        }, 10000);

        $(document).on("click", ".tix-release", function(){
            $.ajax({
                type: "POST",
                url: "release",
                data: {"email_ticket_no": $(this).attr('target-tix'),
                    _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                success: function (response) {
                   if (response.data == true) {
                    toastr.success('Ticket Successfully Released!');
                   } 
                }
            });
        });
        
    });

    
    
    

    function topTableDetails(){
        var activeTickets = $('#activeDBody');
        emptyDestroy( $('#activityDetails'), 'destroy');
        emptyDestroy( activeTickets, 'empty');
        $.ajax({
            type: "GET",
            url: "myteamticketdetails",
            success: function (response) {
                // console.log("A");
                $('.activelog').html('').html(response.activeCount);
                $('.totaltix').html('').html(response.totalTicket);
                $('.waiting').html('').html(response.waitingTixs);
                $('.processing').html('').html(response.processTixs);
                $('.closed').html('').html(response.closedTix);

                console.log(response.data);

                $.each(response.data,function(k,v){

                    let lapse = "";
                    let d2 = moment(moment().format("YYYY-MM-DD H:m:s"));

                    if (v['start_process_time'] == null) {
                        let d1 = moment(moment().format(v['dt_locked']));
                            lapse = d2.diff(d1, 'minutes') + " minutes pending";
                    } else {
                        let d1 = moment(moment().format(v['start_process_time']));
                            lapse = d2.diff(d1, 'minutes') + " minutes processing";
                    }
                    

                    activeTickets.append(
                        "<tr>"+
                            "<td>"+v['ticket_code']+"</td>"+
                            "<td>"+v['call_sign']+"</td>"+
                            "<td>"+v['name']+"</td>"+
                            "<td>"+v['specification']+"</td>"+
                            "<td>"+(v['queue'] != "" ? "Email Support" : "--")+"</td>"+
                            "<td>"+lapse+"</td>"+
                            "<td style='text-align: center'><button target-tix='"+v['ticket_code']+"' type='button' class='tix-release btn btn-danger'><i class='fa fa-link'></i></button></td>"+
                        "</tr>"
                    );
                });

                $('#activityDetails').DataTable({pageLength : 5, "bLengthChange": false});
                $("#activityDetails").DataTable().draw();
            }
        });
    }
    
</script>