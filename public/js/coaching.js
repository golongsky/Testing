$(document).ready(function() {
  var today = new Date(),
      dateField = ["goalEndDate", "goalStartDate"],
      date = (today.getMonth()+1)+'/'+today.getDate()+'/'+today.getFullYear(),
      scheduleSessionValidator = $("#scheduleSession").validate({
          errorPlacement: function(error, element) {
            error.appendTo(element.parent('div').find('div'));
          }
      }),
      goalValidator = $("#goalForm").validate(),
      milestoneValidator = $("#milestoneForm").validate();
      feedbackValidator = $("#feedbackForm").validate();

  $('.attendees, .forms').select2({
    width: 'resolve' 
  });

  $("#scheduleSession, #sessionSaveBtn, #sessionBack, #sessionUpdateBtn, .goal-details, .goal-btn, .btn-goal-back, .goal-form, #createMilestone, .milestone-form, #updateGoal, .milestone-btn, .show-milestone, .no-milestone-created, #backMilestoneArrow, #backFeedbackArrow, #updateMilestone, .show-feedback, .feedback-form, .feedback-btn, #updateFeedback, #backFeedbackArrow, .agent-form").hide();


  $(".sessionDateAndTime").daterangepicker({
    singleDatePicker: true,
    timePicker: true,
    minDate: date,
    drops: "auto",
    locale: {
      format: 'MM/DD/YYYY h:mm A',
      cancelLabel: 'Clear'
    }
  });

  $("#goalEndDate, #goalStartDate, #milestoneStartDate").daterangepicker({
    singleDatePicker: true,
    minDate: date,
    drops: "auto",
    locale: {
      format: 'MM/DD/YYYY',
      cancelLabel: 'Clear'
    }
  });


  for (let index = 0; index < dateField.length; index++) {
    $('input[id="'+ dateField[index] +'"]').on('apply.daterangepicker', function(ev, picker) {
        console.log("dito kaya?")
        $(this).val(picker.startDate.format('MM/DD/YYYY'));
    });
  
    $('input[id="'+ dateField[index] +'"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    
};
  

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
  
// Coach Access Level
  $('.coach-mod').on("click", function () {
    var targetId = $(this).attr('target-id');
    console.log(targetId);
    callAgentDetails(targetId);
    // loadSessionPerAgent(targetId);
  });

  // Agent Access Level
  $(document).on('click', '.show-sp-session' ,function () {
    var targetId = $(this).attr('target-id'),
        sessionId = $(this).attr('session-id');
    callAgentDetails(targetId);
    loadSessionPerAgent(targetId, sessionId);
  });
  


  // schedule session btn
  $(".scheduleSessionBtn").on("click", function() {
    $(".form-upload-preloader").show();
    getAttendees();
    getForms();
    loadSession();
  });

  // show goal
  $(document).on('click', '.show-goal', function(){
    var targetId = $(this).attr('target-id');
    $(".goal-details, .btn-goal-back, .goal-form-agent").show();
    $(".coaching-table-container").hide();
    $("#session").val(targetId);
    goalDetails(targetId);
  });

  // show goal agent
  $(document).on('click', '.show-goal-agent', function(){
    var targetId = $(this).attr('target-id');
    console.log("target to");
    console.log(targetId);
    $(".goal-details, .btn-goal-back").show();
    $(".coaching-table-container").hide();
    $("#session").val(targetId);
    goalDetailsAgent(targetId);
  });


  // goal back button
  $(document).on('click', '.btn-goal-back', function() {
    $(".coaching-table-container").show();
    $(".goal-details, .btn-goal-back, #updateGoal, #updateMilestone").hide();
  });

  // create goal btn
  $(document).on('click', '.btn-add-goal', function(){
    $(".goal-header").html("Create Goal");
    $(".goal-form, .goal-btn, .goal-form-agent").show();
    $(".goal-field").val("");
    $(".goal-details, .btn-goal-back, .milestone-btn").hide();
  });

   // goal form back btn
  $(document).on('click', '#backGoal', function(){
    $(".goal-form, .goal-btn").hide();
    $(".goal-details, .btn-goal-back").show();
  });

  // update goal
  $(document).on('click', '.update-goal-details', function(){
    var _targetId = $(this).attr('id');
    $(".goal-form, #backGoal, .form-upload-preloader, #updateGoal, .goal-form-agent").show();
    $(".goal-details, .btn-goal-back, .milestone-btn").hide();
    $.ajax({
      type: "POST",
      url: "showgoal",
      data: {
          "target_id"     : _targetId,
          _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          $.each(response.data,function(index, value){
                $(".goal-header").html("Update Goal");
                $("#goalId").val(value['id']);
                $("#goalTitle").val(value['title']);
                $("#goalDescription").val(value['description']);
                $("#goalStartDate").val(value['start_date']);
                $("#goalEndDate").val(value['end_date']);
        });
        $(".form-upload-preloader").hide();
      }
    });
  });

  $(document).on('click', '#updateGoal',function(e){
    var title = $("#goalTitle").val(),
        id =  $("#goalId").val(),
        description = $("#goalDescription").val(),
        startDate = $("#goalStartDate").val(),
        endDate = $("#goalEndDate").val();
    e.preventDefault();
    goalValidator.form();
    if($("#goalForm").valid() == true){
      $.ajax({
        type: "POST",
        url: "updategoal",
        data: {
          "id"                  : id,
          "title"               : title,
          "description"         : description,
          "start_date"          : startDate,
          "end_date"            : endDate,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(">>>>>>>update goal success");
            goalDetails(response.coaching_id);
            goalDetailsAgent(response.coaching_id);
            toastr.success(response.title +' Successfully Updated!');
            $("#backGoal").trigger('click');
            $("#createMilestone").show();
            $("#createGoal, #createMilestone, #updateGoal, .goal-form-agent").hide();

        },
        error: function (response) {
            console.log(">>>>>>>goal error");
            console.log(response);
        }
      });
    } else {
      // nothing to do
    }
  })







  // create milestone
  $(document).on('click', '.btn-add-milestone', function(){
    $(".milestone-form, .milestone-btn, .milestone-form-agent").show();
    $(".goal-details, .btn-goal-back, #updateGoal").hide();
    $(".milestone-label").html("Create Milestone");
  });

  // milestone back button
  $(document).on('click', '#backMilestone, #backMilestoneArrow', function(){
    $(".milestone-form, .milestone-btn, .show-milestone, #updateMilestone, .show-milestone-agent").hide();
    $(".goal-details, .btn-goal-back").show();
  });

  // feedback back button
  $(document).on('click', '#backFeedbackArrow, #backFeedback', function(){
    console.log("pumapasok dito?")
    $(".show-feedback-agent, .show-feedback, #backFeedbackArrow").hide();
    $(".show-milestone-agent, .show-milestone, #backMilestoneArrow").show();
  });

  // decline coaching
  $(document).on('click', '.btn-reject', function(){
    var targetId = $(this).attr("target-id"),
        accept = "Decline";
    (async () => {
      const reason = await Swal.fire({
        title: 'Decline?',
        input: 'text',
        text: "Do you really want to decline this session? this process cannot be undone.",
        inputLabel: 'Reason',
        confirmButtonText: 'Decline',
        icon: 'question',
        inputPlaceholder: 'Enter your reason'
      }).then((result) => {
        var reason = result.value;
        if (result.isConfirmed) {
          // $(".form-upload-preloader").show();
          $.ajax({
            type: "POST",
            url: "accepdeclinecoaching",
            data: {
              "id"         : targetId,
              "status"     : accept,
              "reason"     : reason,
              _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                toastr.success('Decline Successfully!');
                $(".form-upload-preloader").hide();
                location.reload();
            }
          });
          
        }
      });
    })()

  });

  // accept coaching
  $(document).on('click', '.btn-accept', function(){
    var targetId = $(this).attr("target-id"),
        accept = "Accept";
    Swal.fire({
      title: 'Are you Sure?',
      text: "Do you really want to accept this session? this process cannot be undone.",
      icon: 'question',
      confirmButtonText: 'Yes',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
  }).then((result) => {
      if (result.isConfirmed) {
        // $(".form-upload-preloader").show();
        $.ajax({
          type: "POST",
          url: "accepdeclinecoaching",
          data: {
            "id"         : targetId,
            "status"     : accept,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          dataType: "json",
          success: function (response) {
              toastr.success('Accepted Successfully!');
              $(".form-upload-preloader").hide();
              location.reload();
  
          }
        });
        
      }
    })
  });

  // show milestone
  $(document).on('click', '.show-milestone-btn', function(){
    var goalId = $(this).attr("id");

    $(".show-milestone, #backMilestoneArrow, .show-milestone-agent").show();
    $(".goal-details, .btn-goal-back, #updateGoal").hide();
    $(".events").html("");
    $.ajax({
      type: "POST",
      url: "showmilestone",
      data: {
          "id"     : goalId,
          _token: $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      success: function(response){
        $(".no-milestone-created").show();
        $.each(response.data,function(k,v){
          var milestoneContainerLi = "<li class='list-inline-item event-list'></li>",
              update = "<a type='button' class='btn btn-primary update-milestone' id='"+ v['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>";
              milestoneContainerDiv = "<div class='px-4'></div>",
              milestoneDate = "<div class='event-date bg-soft-primary text-primary'>" +v['milestone_date']+ "</div>",
              // milestoneRemarksLabel = "<h5 class='font-size-16'>Remarks</h5>",
              milestoneRemarks = "<p class='text-muted'>"+ v['remarks'] +"</p>",
              milestoneAction = "<div class='btn-milestone-action'><a class='btn btn-secondary btn-sm mr-1 mb-1 update-milestone-btn' id='"+ v['id'] +"'><i class='nav-icon fas fa-pen-nib'></i></a>  <a href='#' class='btn btn-info btn-sm mr-1 mb-1 show-feedback-container' id='"+ v['id'] +"'><i class='nav-icon fas fa-eye'></i></a></div>";
              $(".no-milestone-created").hide();

            $(".events").append($(milestoneContainerLi).append($(milestoneContainerDiv).append(milestoneDate, milestoneRemarks, milestoneAction)));
        });
        
      }
    });
  });


  // Update Milestone link
  $(document).on('click', '.update-milestone-btn', function(e){
    e.preventDefault();
    var milestoneId = $(this).attr("id");
    $(".milestone-form, #updateMilestone, #backMilestone, .milestone-form-agent").show();
    $(".show-milestone, #backMilestoneArrow, .show-milestone-agent").hide();
    $(".milestone-label").html("Update Milestone");
    $.ajax({
      type: "POST",
      url: "showselectedmilestone",
      data: {
        "id"     : milestoneId,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      success: function(response){
        $.each(response.data,function(k,v){
          $("#milestoneId").val(v['id']);
          $("#milestoneRemarks").val(v['remarks']);
          $("#milestoneStartDate").val(v['milestone_date']);
          
        });
        $("#updateMilestone").show();
      }
    });
  });

  $(document).on('click', '#updateMilestone',function(e){
    e.preventDefault();
    var id =  $("#milestoneId").val(),
        remarks = $("#milestoneRemarks").val(),
        milestoneStartDate = $("#milestoneStartDate").val();
    
    milestoneValidator.form();
    if($("#milestoneForm").valid() == true){
      $.ajax({
        type: "POST",
        url: "updateMilestone",
        data: {
          "id"                  : id,
          "remarks"             : remarks,
          "milestone_date"      : milestoneStartDate,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(">>>>>>>update goal success");
            console.log(response);
            toastr.success(response['remarks'] +' Successfully Updated!');
            $("#backMilestone").trigger('click');
            $("#updateMilestone, .milestone-form-agent").hide()

        }
      });
    }
  })



  // show feedback
  $(document).on('click', '.show-feedback-container', function(){
    var milestoneId = $(this).attr('id');
    $(".show-milestone, #backMilestoneArrow, .show-milestone-agent, #backMilestoneArrow").hide();
    $(".show-feedback, .show-feedback-agent, #backFeedbackArrow").show();
    showFeedback(milestoneId);
    $("#milestoneValue").val(milestoneId);

  });

  // add feedback
  $(".add-feedback").on('click', function(){
    $(".show-feedback, .show-feedback-agent").hide();
    $(".feedback-form, .feedback-btn, .feedback-form-agent").show();
  });

  // back feedback btn
  $("#backFeedback").on('click', function() {
    $(".feedback-form, .feedback-btn, .feedback-form-agent").hide();
    $(".show-feedback, .show-feedback-agent").show();
  });

  // create feedback btn
$(document).on('click','#createFeedback', function(e){
  e.preventDefault();
  feedbackValidator.form();
  ($("#feedbackForm").valid() == false ? "":$("#feedbackForm").submit());
});

// feedback submit
$("#feedbackForm").on('submit', function(e){
  e.preventDefault();
  var milestoneId = $("#milestoneValue").val(),
      remarks = $("#feedbackField").val();

      $.ajax({
        type: "POST",
        url: "createfeedback",
        data: {
          "milestone_id"         : milestoneId,
          "remarks"              : remarks,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(">>>>>>>feedback success");
            console.log(response);
            toastr.success('Feedback '+ response.remarks +' Successfully Created!');
            $("#backFeedback").trigger('click');
            $("#milestoneValue").val(response.milestone_id)
            $(".feedback-field").val("");
           showFeedback(response.milestone_id) ;

        },
        error: function (response) {
            console.log(">>>>>>>feedback error");
            console.log(response);
        }
      });

});




  $("#custom-tabs-coaching-tab").on('click', function(){
    $(".coaching-table-container").show();
    $(".goal-details, .btn-goal-back, .show-milestone, #updateGoal, .feedback-form, .feedback-btn, #updateFeedback, .show-feedback").hide();
  });

  $("#newSession").on("click", function(){
    $("#scheduleSession, #sessionSaveBtn, #sessionBack").show();
    $(".tableContainer, #newSession, #sessionUpdateBtn").hide();
    clearField();
    loadDurationHour();
    loadDurationMinutes();
  });

  $("#sessionBack").on("click", function(){
    var sessionField = ["#sessionTitle", "#attendees", "#forms", "#sessionLink", "#sessionDateAndTime", "#durationHours", "#durationMinutes"];
    $("#scheduleSession, #sessionSaveBtn, #sessionBack, #sessionUpdateBtn").hide();
    $(".tableContainer, #newSession").show();
    clearField();
    loadDurationHour();
    loadDurationMinutes();
    fieldReset(sessionField);
  });

  $("#sessionSaveBtn").on("click", function(e){
    e.preventDefault();
    // console.log(endDateSession);
    scheduleSessionValidator.element("#sessionTitle");
    scheduleSessionValidator.element("#attendees");
    scheduleSessionValidator.element("#forms");
    scheduleSessionValidator.element("#sessionDateAndTime");
    scheduleSessionValidator.element("#sessionLink");
    scheduleSessionValidator.element("#durationHours");
    scheduleSessionValidator.element("#durationMinutes");
    // console.log(today.getHours());
    ($("#scheduleSession").valid() == false ? "":$("#scheduleSession").submit());
});

// create goal btn
$(document).on('click','#createGoal', function(e){
  e.preventDefault();
  goalValidator.form();
  ($("#goalForm").valid() == false ? "":$("#goalForm").submit());
});

// goal submit
$("#goalForm").on('submit', function(e){
  e.preventDefault();
  var title = $("#goalTitle").val(),
      description = $("#goalDescription").val(),
      session = $("#session").val(),
      startDate = $("#goalStartDate").val(),
      endDate = $("#goalEndDate").val();

      $.ajax({
        type: "POST",
        url: "creategoal",
        data: {
          "coaching_id"         : session,
          "title"               : title,
          "description"         : description,
          "start_date"          : startDate,
          "end_date"            : endDate,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(">>>>>>>goal success");
            console.log(response.coaching_id);
            goalDetails(response.coaching_id);
            goalDetailsAgent(response.coaching_id);
            toastr.success(response.title +' Successfully Created!');
            $("#backGoal").trigger('click');
            $("#createMilestone").show();
            $("#createGoal, #createMilestone, .goal-form-agent").hide();

        },
        error: function (response) {
            console.log(">>>>>>>goal error");
            console.log(response);
        }
      });

});

// delete goal
$(document).on('click', '.delete-goal-details', function(){
  var goalId = $(this).attr('id');
  Swal.fire({
      title: 'Are you Sure?',
      text: "Do you really want to delete this goal? this process cannot be undone.",
      icon: 'error',
      confirmButtonText: 'Yes',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
  }).then((result) => {
      if (result.isConfirmed) {
        $(".form-upload-preloader").show();
        $.ajax({
          type: "POST",
          url: "deletegoal",
          data: {
            "id"         : goalId,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          dataType: "json",
          success: function (response) {
              toastr.success('Goal Successfully Deleted!');
              goalDetails(response.coaching_id);
              goalDetailsAgent(response.coaching_id);
              $(".form-upload-preloader").hide();
  
          }
        });
        
      }
    })
});



// create milestone btn
$(document).on('click','#createMilestone', function(e){
  e.preventDefault();
  milestoneValidator.form();
  ($("#milestoneForm").valid() == false ? "":$("#milestoneForm").submit());
});

// milestone submit
$("#milestoneForm").on('submit', function(e){
  e.preventDefault();
  var goalId = $("#goalMilestoneId").val(),
      remarks = $("#milestoneRemarks").val(),
      startDate = $("#milestoneStartDate").val();

      $.ajax({
        type: "POST",
        url: "createmilestone",
        data: {
          "goal_id"         : goalId,
          "start_date"      : startDate,
          "remarks"         : remarks,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(">>>>>>>milestone success");
            console.log(response);
            toastr.success('Milestone '+ response.remarks +' Successfully Created!');
            $("#backMilestone").trigger('click');
            $(".milestone-field").val("");
            $(".milestone-form-agent").hide();
            

        },
        error: function (response) {
            console.log(">>>>>>>goal error");
            console.log(response);
        }
      });

});



// schedule session submit
$("#scheduleSession").on("submit", function(e){
  e.preventDefault();
  var data = new FormData(),
      file = $('#customScheduleFile')[0].files[0],
      endDate = $("#sessionDateAndTime").val(),
      startDate = $("#sessionDateAndTime").val().toString(),
      setStartDate = new Date(startDate),
      getStartDate = setStartDate.getDate(),
      getStartMonth = setStartDate.getMonth(),
      getStartYear = setStartDate.getFullYear(),
      getStartHours = setStartDate.getHours(),
      getStartMinutes = setStartDate.getMinutes(),
      durationHours = ($("#durationHours").val() == "" ? 0:$("#durationHours").val()),
      durationMinutes = ($("#durationMinutes").val() == "" ? 0:$("#durationMinutes").val()),
      setEndHoursDuration = (parseInt(getStartHours) + parseInt(durationHours)),
      setEndMinutesDuration = (parseInt(getStartMinutes) + parseInt(durationMinutes)),
      setEndDateSession = getStartDate + " " + setEndHoursDuration + ":" + setEndMinutesDuration,
      initializeEndDateSession = new Date(getStartYear, getStartMonth, getStartDate).setHours(setEndHoursDuration, setEndMinutesDuration);
      endDateSession = new Date(initializeEndDateSession),
      formatDate = moment(endDateSession).format('MM/DD/YYYY h:mm A');

  // console.log(endDate);
  data.append('file', file);
  data.append('title', $("#sessionTitle").val());
  data.append('description', $("#sessionDescription").val());
  data.append('attendees', $("#attendees").val());
  data.append('survey_forms', $("#forms").val());
  data.append('session_link', $("#sessionLink").val());
  data.append('start_date_session', $("#sessionDateAndTime").val());
  data.append('end_date_session', formatDate);
  data.append('duration_hours', $("#durationHours").val());
  data.append('duration_minutes', $("#durationMinutes").val());
  data.append('_token', $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
    type: "POST",
    url: "schedule-session",
    data: data,
    processData: false,
    contentType: false,
    success: function (response) {
        console.log(response);
        toastr.success(response.title +' Successfully Created!');
        $("#sessionBack").trigger("click");
        clearField();
        getForms();
        getAttendees();
    },
    error: function (response) {
        console.log(response);
        // var errorStatusText = response.statusText;
        // var errorStatusCode = response.status
        // toastr.error(errorStatusCode + " : " + errorStatusText );
    }
  });
    
});


$(document).on("click", ".update-schedule-session", function(){
    var updateId = $(this).attr('id');
    $("#scheduleSession, #sessionBack, .form-upload-preloader, #sessionUpdateBtn").show();
    $(".tableContainer, #newSession").hide();
    $(".sessionTitle").html("").html("Updated Schedule Session");
    loadDurationHour();
    loadDurationMinutes();
    $.ajax({
      type: "POST",
      url: "get-session-data",
      data: {
        "id" : updateId,
        _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          console.log(">>>>>>>>>success");
          console.log(response.data);
          var attendees = response.data.attendees.replace('"','').replace('"','').split(","),
              forms = response.data.forms.replace('"','').replace('"','').split(",");

          $("#sessionId").val(response.data.id);
          $("#sessionTitle").val(response.data.title);
          $("#sessionLink").val(response.data.session_link);
          $("#sessionDescription").val(response.data.description);
          $('#attendees').val(attendees).trigger('change');
          $('#forms').val(forms).trigger('change');
          $("#durationHours").val(response.data.durationHours).trigger('change');
          $("#durationMinutes").val(response.data.durationMinutes).trigger('change');
          $(".form-upload-preloader").hide();
          
      }
    });
  });

  $(document).on('click', "#sessionUpdateBtn",  function(e){
    e.preventDefault();
  var data = new FormData(),
      file = $('#customScheduleFile')[0].files[0],
      endDate = $("#sessionDateAndTime").val(),
      startDate = $("#sessionDateAndTime").val().toString(),
      setStartDate = new Date(startDate),
      getStartDate = setStartDate.getDate(),
      getStartMonth = setStartDate.getMonth(),
      getStartYear = setStartDate.getFullYear(),
      getStartHours = setStartDate.getHours(),
      getStartMinutes = setStartDate.getMinutes(),
      durationHours = ($("#durationHours").val() == "" ? 0:$("#durationHours").val()),
      durationMinutes = ($("#durationMinutes").val() == "" ? 0:$("#durationMinutes").val()),
      setEndHoursDuration = (parseInt(getStartHours) + parseInt(durationHours)),
      setEndMinutesDuration = (parseInt(getStartMinutes) + parseInt(durationMinutes)),
      setEndDateSession = getStartDate + " " + setEndHoursDuration + ":" + setEndMinutesDuration,
      initializeEndDateSession = new Date(getStartYear, getStartMonth, getStartDate).setHours(setEndHoursDuration, setEndMinutesDuration);
      endDateSession = new Date(initializeEndDateSession),
      formatDate = moment(endDateSession).format('MM/DD/YYYY h:mm A');

    // console.log(endDate);
    data.append('file', file);
    data.append('id', $("#sessionId").val());
    data.append('title', $("#sessionTitle").val());
    data.append('description', $("#sessionDescription").val());
    data.append('attendees', $("#attendees").val());
    data.append('survey_forms', $("#forms").val());
    data.append('session_link', $("#sessionLink").val());
    data.append('start_date_session', $("#sessionDateAndTime").val());
    data.append('end_date_session', formatDate);
    data.append('duration_hours', $("#durationHours").val());
    data.append('duration_minutes', $("#durationMinutes").val());
    data.append('_token', $('meta[name="csrf-token"]').attr('content'));
    $.ajax({
        type: "POST",
        url:"update-session-data",
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(">update eto>")
            console.log(response);
            toastr.success('Session successfully updated.');
            // clearfields()
            $("#sessionBack").trigger("click");
            loadSession();
        },
        error: function(response) {
            console.log("-error-");
            console.log(response);
        }

    });
  });

  
  function getAttendees(){
    $("#attendees").html("");
    $.ajax({
        type: "GET",
        url: "all-user",
        success: function (response) {
          
            $.each(response.data,function(k,v){
                $('.attendees').append("<option value='"+v['id']+"'>"+v['name']+"</option>");
            });
        }
    });
  };

  function clearField(){
    $(".schedule-session-field").val("").html("");
    getAttendees();
    getForms();
    $(".sessionTitle").html("").html("Schedule Session");
  };

  function fieldReset(element) {
    $.each(element, function(key, value){
        if ($(value).hasClass('error')) {
            $(value).removeClass("error");
            $(value).siblings('.error').remove();
            $(".error-container").html("");
            
        }
    });
    
};
  
  function getForms(){
    $("#forms").html("");
    $.ajax({
        type: "GET",
        url: "pull-form",
        dataType: "json",
        success: function (response) {
          $.each(response.data,function(k,v){
              $('.forms').append("<option value='"+v['id']+"'>"+v['form_name']+"</option>");
          });
        },
        error: function (response) {
            console.log("<<<<<<<<<<<<<<<<<<<<<<<")
            console.log(response);
        }
    });
  };

  function callAgentDetails(_targetId){
    var coachingList = $('.coaching-agent-log');
    $('#coachingAgentTable').DataTable().destroy();
    coachingList.empty();
    $.ajax({
      type: "POST",
      url: "pulldetails",
      data: {
          "target_id"     : _targetId,
          _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          console.log(">>>>>>>>>>Success");
          console.log(response);
          $(".agent-name").html('').html(response.data[0]['name']);
          $('.agent-tl').html('').html(response.tl);
          $('.agent-sm').html('').html(response.sm);
          $('.agent-sign').html('').html(response.data[0]['call_sign']);
          $('.agent-user').html('').html(response.data[0]['name']);
          $('.agent-position').html('').html(response.position);
          $('.group-agent').html('').html(response.data[0]['subgroup_name']);
          $('.agent-location').html('').html(response.data[0]['group_name']);
          $('.agent-tenure').html('').html(response.tenure + " Months")

          $.each(response.coaching_logs,function(index, value){
            var update = "<a type='button' class='btn btn-primary update-schedule-session' id='"+ value['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>";
                count = index + 1,
                goal = "<a class='show-goal' style='cursor: pointer' target-id='"+ value['id'] +"'>Show Goal</a>",
                information = "<a class='show-information' style='cursor: pointer'>Show Details</a>"
                progress = "<div class='progress progress-xs'><div class='progress-bar bg-warning' style='width: 70%'></div></div>";
               
            
            coachingList.append(
                "<tr>"+
                    "<td>"+ count +"</td>"+
                    "<td>"+  value['coaching_date'] +"</td>"+
                    "<td>"+  progress +"</td>"+
                    "<td>"+  value['title'] +"</td>"+
                    "<td>"+  " Details " +"</td>"+
                    "<td>"+  goal +"</td>"+
                    "<td>"+ value['status']  +"</td>"+
                "</tr>"
            );
        });
        sessionDatatable("coachingAgentTable");
        // $(".form-upload-preloader").hide();
      }
    });
  }



  function loadSessionPerAgent(_targetId, _sessionId){
    var coachingList = $('.coaching-details-log-agent-list');
    coachingList.empty();
    $.ajax({
      type: "POST",
      url: "pullSession",
      data: {
          "target_id"       : _targetId,
          "coaching_id"     : _sessionId,
          _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
        $.each(response.data,function(index, value){
            var update = "<a type='button' class='btn btn-primary update-schedule-session' id='"+ value['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>";
                count = index + 1,
                goal = "<a class='show-goal-agent' style='cursor: pointer' target-id='"+ value['id'] +"'>Show Goal</a>",
                information = "<a class='show-information' style='cursor: pointer'>Show Details</a>"
                progress = "<div class='progress progress-xs'><div class='progress-bar bg-warning' style='width: 70%'></div></div>";
              
            
            coachingList.append(
                "<tr>"+
                    "<td>"+ count +"</td>"+
                    "<td>"+  value['coaching_date'] +"</td>"+
                    "<td>"+  progress +"</td>"+
                    "<td>"+  value['title'] +"</td>"+
                    "<td>"+  " Details " +"</td>"+
                    "<td>"+  goal +"</td>"+
                    "<td>"+ information  +"</td>"+
                "</tr>"
            );
        });
          
        // $(".form-upload-preloader").hide();
      }
    });
  }

  function loadSession(){
      $('#sessionTable').DataTable().destroy();
      var sessionList = $('.session-list');
      sessionList.empty();
      $.ajax({
          type: "GET",
          url: "showCreatedSesssion",
          dataType: "json",
          success: function (response) {
              console.log(response);
              $.each(response.data,function(index, value){
                  var update = "<a type='button' class='btn btn-primary update-schedule-session' id='"+ value['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>";
                  count = index + 1;
                  sessionList.append(
                      "<tr>"+
                          "<td>"+ count +"</td>"+
                          "<td>"+  value['title'] +"</td>"+
                          // "<td>"+  value['form_created_by'] +"</td>"+
                          // "<td>"+  value['created_by'] +"</td>"+
                          "<td>"+  value['start_date_session'] +"</td>"+
                          // "<td>"+  " " +"</td>"+
                          "<td>"+  value['forms'] +"</td>"+
                          "<td>"+ update  +"</td>"+
                      "</tr>"
                  );
              });
              sessionDatatable("sessionTable");
              $(".form-upload-preloader").hide();
          },
          error: function (response) {
              console.log("<<<<<<<<<<<<<<<<<<<<<<<")
              console.log(response);
          }
      });
  };

  function loadDurationHour() {
    var hourArray = ["0 hours","1 hours","2 hours", "3 hours", "4 hours","5 hours", "6 hours", "7 hours", "8 hours", "9 hours", "10 hours", "11 hours", "12 hours", "18 hours", "24 hours"];
    for (let index = 0; index < hourArray.length; index++) {
      $("#durationHours").append($('<option>', {
        value: index,
        text : hourArray[index]
      }));
      
    }
  }

  function loadDurationMinutes() {
    var minutesArray = ["0 minutes","10 minutes","15 minutes", "20 minutes", "25 minutes","30 minutes", "35 minutes", "40 minutes", "45 minutes", "50 minutes", "55 minutes"];
    for (let index = 0; index < minutesArray.length; index++) {
      $("#durationMinutes").append($('<option>', {
        value: index,
        text : minutesArray[index]
      }));
      
    }
  }

  // load goal TL
  function goalDetails(_targetId){
    var goalList = $('.goal-log');
    $(".form-upload-preloader").show();
    $('#coachingAgentGoal').DataTable().destroy();
    goalList.empty();
    $.ajax({
      type: "POST",
      url: "showgoal",
      data: {
          "target_id"     : _targetId,
          _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          console.log(">>>>>>>>>>goaldetails>>>>>>>>>>>")
          console.log(response);
          $(".btn-add-goal").show();
          $(".btn-add-milestone").hide();
          $.each(response.data,function(index, value){
            var count = index + 1,
                goal = "<a class='show-goal' style='cursor: pointer' target-id='"+ value['id'] +"'>Show Goal</a>",
                milestone = "<a class='show-milestone-btn' id='"+ value['id'] +"' style='cursor: pointer'>Show Milestone</a>",
                progress = "<div class='progress progress-xs'><div class='progress-bar bg-warning' style='width: 70%'></div></div>",
                update = "<a type='button' class='btn btn-primary update-goal-details' id='"+ value['coaching_id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>",
                deleteGoal = "<a type='button' class='btn btn-danger delete-goal-details' id='"+ value['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='nav-icon fas fa-trash'></i></a>";

                $("#goalMilestoneId").val(value['id']);
                $(".btn-add-milestone").show();
                $(".btn-add-goal").hide();
                goalList.append(
                "<tr>"+
                    "<td>"+ count +"</td>"+
                    "<td>"+  value['title'] +"</td>"+
                    "<td>"+  progress +"</td>"+
                    "<td>"+  milestone +"</td>"+
                    "<td>"+  value['start_date'] +"</td>"+
                    "<td>"+ value['end_date']  +"</td>"+
                    "<td>"+ update + " " + deleteGoal  +"</td>"+
                "</tr>"
            );
        });
        sessionDatatable("coachingAgentGoal");
        $(".form-upload-preloader").hide();
      }
    });
  }

  // load goal Agent
  function goalDetailsAgent(_targetId){
    var goalList = $('.goal-log-agent');
    $(".form-upload-preloader").show();
    $('#coachingDetailsGoal').DataTable().destroy();
    goalList.empty();
    $.ajax({
      type: "POST",
      url: "showgoal",
      data: {
          "target_id"     : _targetId,
          _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          console.log(">>>>>>>>>>goaldetails>>>>>>>>>>>")
          console.log(response);
          $(".btn-add-goal").show();
          $(".btn-add-milestone").hide();
          $.each(response.data,function(index, value){
            var count = index + 1,
                goal = "<a class='show-goal' style='cursor: pointer' target-id='"+ value['id'] +"'>Show Goal</a>",
                milestone = "<a class='show-milestone-btn' id='"+ value['id'] +"' style='cursor: pointer'>Show Milestone</a>",
                progress = "<div class='progress progress-xs'><div class='progress-bar bg-warning' style='width: 70%'></div></div>",
                update = "<a type='button' class='btn btn-primary update-goal-details' id='"+ value['coaching_id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>",
                deleteGoal = "<a type='button' class='btn btn-danger delete-goal-details' id='"+ value['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='nav-icon fas fa-trash'></i></a>";

                $("#goalMilestoneId").val(value['id']);
                $(".btn-add-milestone").show();
                $(".btn-add-goal").hide();
                goalList.append(
                "<tr>"+
                    "<td>"+ count +"</td>"+
                    "<td>"+  value['title'] +"</td>"+
                    "<td>"+  progress +"</td>"+
                    "<td>"+  milestone +"</td>"+
                    "<td>"+  value['start_date'] +"</td>"+
                    "<td>"+ value['end_date']  +"</td>"+
                    "<td>"+ update + " " + deleteGoal  +"</td>"+
                "</tr>"
            );
        });
        sessionDatatable("coachingDetailsGoal");
        $(".form-upload-preloader").hide();
      }
    });
  }


  // show feedback
  function showFeedback(_targetId) {
    $(".feedback-body").html("");
    $.ajax({
      type: "GET",
      url: "showfeedback",
      data: {
          "id"     : _targetId,
          _token: $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      success: function(response){
        $(".feedback-body").html("<p class='no-feedback-created'>No Feedback Created</p>")
        $.each(response.data,function(k,v){
          console.log(v);
          $(".no-feedback-created").hide();
          var feedbackContainer = "<div class='card p-3'></div>",
              update = "<a type='button' class='btn btn-primary update-milestone' id='"+ v['id'] +"' data-toggle='tooltip' data-placement='bottom' title='Update'><i class='nav-icon fas fa-pen-nib'></i></a>";
              feedbackContentContainer = "<div class='d-flex justify-content-between align-items-center'></div>"
              feedbackUser = "<div class='user d-flex flex-row align-items-center'></div>",
              feedbackImageUser = "<img src='https://i.imgur.com/hczKIze.jpg' width='30' class='user-img rounded-circle mr-2'>",
              feedbackTextContainer = "<span></span>",
              feedbackUserName = "<small class='font-weight-bold text-primary feedback-username'>"+ v['name']+"</small>  ",
              feedbackRemarks = "<small class='font-weight-bold'>"+v['remarks']+"</small>",
              feedbackActionContainer = "<div class='action d-flex justify-content-between mt-2 align-items-center'></div>",
              feedbackActionBtn = "<div class='reply px-4'> <small>Remove</small> <span class='dots'></span> <small>Reply</small> <span class='dots'></span> <small>Translate</small> </div>";
              // milestoneAction = "<div class='btn-milestone-action'><a class='btn btn-secondary btn-sm mr-1 mb-1 update-milestone-btn' id='"+ v['id'] +"'><i class='nav-icon fas fa-pen-nib'></i></a>  <a href='#' class='btn btn-info btn-sm mr-1 mb-1 show-feedback-container' id='"+ v['id'] +"'><i class='nav-icon fas fa-eye'></i></a></div>";
              // $(".no-milestone-created").hide();

            $(".feedback-body").append(
              // container
              $(feedbackContainer).append($(feedbackContentContainer)
              // User container
              .append($(feedbackUser)
              // user image
              .append(feedbackImageUser)
              // user remarks
              .append($(feedbackTextContainer)
              // user data
              .append(feedbackUserName, feedbackRemarks)
              ))).append($(feedbackActionContainer)
              .append(feedbackActionBtn)));
        });
        
      }
    });
  }

  function sessionDatatable(_table) {
    $("#"+ _table).DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false, "lengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[ 0, "desc" ]]
      }).buttons().container().appendTo('#' + _table + '_wrapper .col-md-6:eq(0)');
}
});