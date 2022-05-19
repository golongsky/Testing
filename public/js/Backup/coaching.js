$(document).ready(function() {


      

      if ($('.active-access-id').val() == 1) {
        $("#agentTbl").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "lengthMenu": [[6, 10, 15, 20], [6, 10, 15, 20]],
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "order": [[ 0, "desc" ]]
        }).buttons().container().appendTo('#agentTbl_wrapper .col-md-6:eq(0)');
      }else if ($('.active-access-id').val() == 2) {
        $("#example3").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false, "lengthMenu": [[6, 10, 15, 20], [6, 10, 15, 20]],
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "order": [[ 0, "asc" ]]
        }).buttons().container().appendTo('#agentTbl_wrapper .col-md-6:eq(0)');
      }
      

      $('.coach-mod').on("click", function () {
        var targetId = $(this).attr('target-id');

        callAgentDetails(targetId) 
      });

      function callAgentDetails(_targetId){
        $.ajax({
          type: "POST",
          url: "pulldetails",
          data: {
              "target_id"     : _targetId,
              _token: $('meta[name="csrf-token"]').attr('content')},
          dataType: "json",
          success: function (response) {
              console.log(response);
              $('.agent-tl').html('').html(response.tl);
              $('.agent-sm').html('').html(response.sm);
              $('.agent-sign').html('').html(response.data[0]['call_sign']);
              $('.agent-user').html('').html(response.data[0]['name']);
              $('.agent-position').html('').html(response.position);
              $('.group-agent').html('').html(response.data[0]['subgroup_name']);
              $('.agent-location').html('').html(response.data[0]['group_name']);
              $('.agent-tenure').html('').html(response.tenure + " Months")
          }
        });
      }
});