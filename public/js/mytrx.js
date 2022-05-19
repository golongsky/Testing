$(document).ready(function() {
  var uploadExcelValidator = $("#uploadExcelForm").validate();

  togglevisible( $('.tbl-loader'), 'show');
  hide_side_bar();
  
  loadMyTrx();


  var intervalHandle = null;
  intervalHandle = window.setInterval(function() {
        if ($('.cur-page').val() == "etr") {
          $.ajax({
              type: "GET",
              url: "last-id",
              success: function (response) {
                console.log(Math.random()+"L_17mytrx");
                if ($('.last-id').val() != response.last_id) {
                  if ($('.active-access-id').val() == 2) {
                    loadMyTrx();
                  }
                }
              }
          });
        }
  }, 15000);


  $('.tracker-window').on("click", function() {
    var newWindow  = window.open("/etrcontroller", "_blank", "toolbar=no,top=500,left=900,width=400,height=400, scrollbars=0");
  });

  $('.etr-filter').on("change", function () {
    var st = $('.ts-start').val(),
        en = $('.ts-end').val();
    
    if (en < st && en != "") {
      toastr.error('End Date Should be Greater than Start Date.');
      return false;
    }

    if (en == "" && st == "") {
      loadMyTrx();
      toastr.success('Current Data Shown.');
    }

    if (en != "" && st != "") {
      var myTrx = $('.tbody-mtrx');

      emptyDestroy( $('#etrTable'), 'destroy');
      emptyDestroy( myTrx, 'empty');
        
      $.ajax({
        type: "POST",
        url: "f-mytrx",
        data: {
          "ts_start"   : st,
          "ts_end"     : en,
          _token: $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        success: function (response) {
          console.log(response.data);
          console.log(Math.random()+"L_62mytrx");
          $.each(response.data,function(k,v){
            myTrx.append(
              "<tr>"+
                "<td>"+v['id']+"</td>"+
                "<td>"+v['name']+"</td>"+
                "<td>"+v['transaction_code']+"</td>"+
                "<td>"+v['transaction_name']+"</td>"+
                "<td>"+(v['meta_state'] == 'Unworkable' ? "Non-Prod" : v['transaction_type'])+"</td>"+
                "<td>"+v['status']+"</td>"+
                "<td>"+v['start_datetime']+"</td>"+
                "<td>"+v['end_datetime']+"</td>"+
                "<td>"+v['total_tat']+"</td>"+
                "<td>"+v['remarks']+"</td>"+
                "<td>"+v['group_name']+"</td>"+
                "<td>"+v['subgroup_name']+"</td>"+
                "<td>"+v['meta_state']+"</td>"+
                "<td>"+v['cName']+"</td>"+
                "<td>"+v['cSName']+"</td>"+
              "</tr>"
            );
          });
          tblInitialize( 'etrTable', 7, 0, 'desc');
          
          setTimeout(function() {
            $("#etrTable").DataTable().draw();
            $('.tbl-loader').hide();
            toastr.success('Table Successfullly Reloaded.');
          }, 3000);
        }
      });
    }
  });


  $('.btn-refresh-tbl').on("click", function() {
    valremovereplace( $('.ts-start'), 0 );
    valremovereplace( $('.ts-end'), 0 );
    loadMyTrx();
  });

  $(".btn-back").on("click", function(){
      var uploadExcelField = ["#file"];
      fieldReset(uploadExcelField);
  });

  $('.btn-open-mylist').on("click", function() {
    $('.tbl-loader').show();
    $(this).hide();
    $('.btn-refresh-tbl').closest('td').hide();
    $('.btn-open-emaillist').show();
    $('.btn-delete-record').closest('td').hide();
    $('.main-card-body').hide();
    $('.email-card-body').show();
    $('.etr-filter').hide();
    $('.upload-td').show();
    loadEmailList();
    pullLastUploadId();
    htmlcontrol( $('#concern'), "<option value='0'>Concern Type</option>" );
    htmlcontrol( $('#subconcern'), "<option value='0'>Sub Concern Type</option>" );
    $('#ticketState').val(0);
    filldropdown(1, 'concern');
  });
  
  $('.btn-open-emaillist').on("click", function() {
    $('.tbl-loader').show();
    $(this).hide();
    $('.btn-refresh-tbl').closest('td').show();
    $('.btn-open-mylist').show();
    $('.btn-delete-record').closest('td').show();
    $('.main-card-body').show();
    $('.email-card-body').hide();
    $('.upload-td').hide();
    $('.etr-filter').show();
    loadMyTrx();
  });

  $(document).on("click", ".toggle-lock",function() {
    var controlId = $("input", this).val(),
        isLock = $(this).hasClass("btn-danger");

    $("i", this).toggleClass("fa-lock-open fa-lock");
    $(this).toggleClass("btn-success btn-danger");
    controlAction(isLock, controlId);
  });

  $("#uploadExcel").on("click", function(){
    uploadExcelValidator.element("#file");
    ($("#uploadExcelForm").valid() == false ? "":$("#uploadExcelForm").submit());
  });

  $("#uploadExcelForm").on("submit", function(e) {
    emptyDestroy( $('#emailList'), 'destroy');
    e.preventDefault();
    $('.form-upload-preloader').show();
    var data = new FormData(),
        file = $('#file')[0].files[0];

    data.append('file', file);
    data.append('_token', $('meta[name="csrf-token"]').attr('content'));
    data.append('file', file);
      $.ajax({
          type: "POST",
          url: "import",
          data: data,
          processData: false,
          contentType: false,
          success: function (response) {
              console.log(response);
              $("#file").val("");
              $(".modal-upload").modal('hide');
              $('.btn-delete-record').attr('target-value',response.uploadId);
              toastr.success(response.success);
              loadEmailList();
              $('.form-upload-preloader').hide();
          },
          error: function (response) {
              console.log(">>>>>>>>>error>>>>>>>>>>>>>")
              console.log(response);
              toastr.error(response);
              $('.form-upload-preloader').hide();
          }
        });

  });

  $(document).on("click", ".btn-delete-record", function(){
    emptyDestroy( $('#emailList'), 'destroy');
    if (typeof $(this).attr('target-value') === "undefined") {
      toastr.error("No Tickets Available for Deletion!!");
      return false;
    }else{
      Swal.fire({
        title: 'Are you sure you want to delete upload Id-'+$(this).attr('target-value')+' ?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "deletupload",
            data: {
              "uploadId"   : $(this).attr('target-value'),
              _token: $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (response) {
              if (response.data == 'success') {
                loadEmailList();
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
              }
            }
          });
          
        }
      })
    }
    
  });

  $(document).on("click", ".email-mod", function(){
    
    
    htmlcontrol( $('.ticket-number'), $(this).attr('ticket-id') );
    var ticketNum = $(this).attr('ticket-id');
    $.ajax({
      type: "POST",
      url: "checkticket",
      data: {
        "ticketNo"   : ticketNum,
        _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
        console.log(Math.random()+"L_203mytrx");
        console.log(response.data);
        if (response.data == 0) {
          locktome(ticketNum);
          $("#modal-lg-email").modal('show');
        }else{
          if (response.data == $('.cur-user-id').val()) {
            $("#modal-lg-email").modal('show');
          }else{
            toastr.error('Ticket already Locked to Another User!!');
            toastr.error('Please Choose Another Ticket!');
          }
          
        } 
      }
    });
  });

  $(document).on("click", "#concern", function(){
    $('#subconcern').html("").append("<option value=''>Sub Concern Type</option>");
    filldropdown( 2, 'subconcern', $(this).val() );
  });

  $(document).on("click", ".copy_text", function(e){
    e.preventDefault();
    var copyText = $(this).attr('href');
 
    document.addEventListener('copy', function(e) {
       e.clipboardData.setData('text/plain', copyText);
       e.preventDefault();
    }, true);
 
    document.execCommand('copy');  
    console.log('copied text : ', copyText);
    toastr.success('Ticket ID copied to clipboard!');
  });


  function filldropdown( _val, _dropdown, _target ){
    $.ajax({
      type: "POST",
      url: "getdropdown",
      dataType: "json",
      data: { targetId : _val, filter: _target, _token: $('meta[name="csrf-token"]').attr('content') },
      success: function (response) {
        $.each(response.data,function(k,v){
          $('#'+_dropdown).append( "<option value='"+v['id']+"'>"+v['name']+"</option>" );
        })
      }
    });
  }




  function controlAction(_isLock, _controlId, _target){
    var isLock = (_isLock == false ? 1 : 0);
    $.ajax({
      type: "POST",
      url: "updateislock",
      dataType: "json",
      data:{
        "control_id"           : _controlId,
        "is_lock"              : isLock,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        toastr.success((isLock == 1 ? "Locked": "Unlock")+' ticket successfully!');
        $('.btn-open-mylist').trigger("click");
      },
      error: function(response) {
        console.log(response);
      }

    });
  };

  function fieldReset(element) {
    $.each(element, function(key, value){
        if ($(value).hasClass('error')) {
            $(value).removeClass("error");
            $(value).siblings('.error').remove();
        }
    });
  };

  
  
  

  function loadMyTrx(){
    var myTrx = $('.tbody-mtrx');

    emptyDestroy( $('#etrTable'), 'destroy');
    emptyDestroy( myTrx, 'empty');

    $.ajax({
      type: "GET",
      url: "mytrx",
      success: function (response) {
        console.log(Math.random()+"L_22mytrx");
        $('.last-id').val(response.last_id);
        $.each(response.data,function(k,v){
          myTrx.append(
            "<tr>"+
              "<td>"+v['id']+"</td>"+
              ($('.active-access-id').val() != 2 ? '<td>'+v['name']+'</td>' : '')+
              "<td>"+v['transaction_code']+"</td>"+
              "<td>"+v['transaction_name']+"</td>"+
              "<td>"+v['transaction_type']+"</td>"+
              "<td>"+v['status']+"</td>"+
              "<td>"+v['start_datetime']+"</td>"+
              "<td>"+v['end_datetime']+"</td>"+
              "<td>"+v['total_tat']+"</td>"+
              "<td>"+(v['remarks'] == null ? "--" : v['remarks'])+"</td>"+
              ($('.active-access-id').val() != 2 ? '<td>'+v['group_name']+'</td>' : '')+
              ($('.active-access-id').val() != 2 ? '<td>'+v['subgroup_name']+'</td>' : '')+

              "<td>"+(v['meta_state'] == null ? "--" : v['meta_state'])+"</td>"+
              "<td>"+(v['meta_type'] == null ? "--" : v['cName'])+"</td>"+
              "<td>"+(v['meta_sub_type'] == null ? "--" : v['cSName'])+"</td>"+
            "</tr>"
          );
        });
        tblInitialize( 'etrTable', 7, 0, 'desc');
        
          setTimeout(function() {
            $("#etrTable").DataTable().draw();
            $('.tbl-loader').hide();
            toastr.success('Table Successfullly Reloaded.');
          }, 3000);
        
        }
    });
  }

  function locktome( _ticketNo ){
    $.ajax({
      type: "POST",
      url: "ticketlock",
      data: {
        "ticketNo"   : _ticketNo,
        _token: $('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
        console.log(Math.random()+"L_62mytrx");
        if (response.data == 'success') {
          toastr.success('Ticket Successfullly Locked.');
          $('.email-mod').removeClass('btn-primary').addClass('btn-danger');
          $('.email-mod').find('i').removeClass('.fa-lock-open').addClass('fa-lock');
        }
      }
    });
  }

  
  setInterval(function(){ 
    checkMyLockedTicket()
  }, 5000);
});