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
          console.log(Math.random()+"L_62mytrx");
          $.each(response.data,function(k,v){
            myTrx.append(
              "<tr>"+
                "<td>"+v['id']+"</td>"+
                "<td>"+v['name']+"</td>"+
                "<td>"+v['transaction_code']+"</td>"+
                "<td>"+v['transaction_name']+"</td>"+
                "<td>"+v['transaction_type']+"</td>"+
                "<td>"+v['status']+"</td>"+
                "<td>"+v['start_datetime']+"</td>"+
                "<td>"+v['end_datetime']+"</td>"+
                "<td>"+v['total_tat']+"</td>"+
                "<td>"+v['remarks']+"</td>"+
                "<td>"+v['group_name']+"</td>"+
                "<td>"+v['subgroup_name']+"</td>"+
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
    $('.btn-open-emaillist').show();
    $('.main-card-body').hide();
    $('.email-card-body').show();
    emptyDestroy( $('#emailTable'), 'destroy');
    $('.ts-end').attr('disabled', true);
    $('.ts-start').attr('disabled', true);
    $('.upload-td').show();
    loadEmailList();
  });
  
  $('.btn-open-emaillist').on("click", function() {
    $('.tbl-loader').show();
    $(this).hide();
    $('.btn-open-mylist').show();
    $('.main-card-body').show();
    $('.email-card-body').hide();
    $('.upload-td').hide();
    $('.ts-end').attr('disabled', false);
    $('.ts-start').attr('disabled', false);
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
              $('#emailTable').DataTable().destroy();
              console.log(response);
              $("#file").val("");
              $(".modal-upload").modal('hide');
              toastr.success(response);
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

  $(document).on("click", ".email-mod", function(){
    htmlcontrol( $('#concern'), "<option value=''>Concern Type</option>" );
    htmlcontrol( $('#subconcern'), "<option value=''>Sub Concern Type</option>" );
    $('#ticketState').val(0);
    filldropdown(1, 'concern');
    
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

  function loadEmailList(){
    var emailList = $('.tbody-email');
    emptyDestroy( $('#emailList'), 'destroy');
    emptyDestroy( $('#emailList'), 'empty');
    
    $.ajax({
      type: "GET",
      url: "emailist",
      success: function (response) {
        console.log(response.data);
        var controllerCol  = "";

        $.each(response.data,function(k,v){
          var lockBtn =  "<td>"+
                            "<button class='btn btn-danger toggle-lock'>"+
                              "<input class='control-id' type='hidden' value='"+ v['id'] +"'>"+
                              "<i class='fas fa-lock' style='font-weight: bolder;color: #fff;'></i>"+
                            "</button>"+
                        "</td>",
            unLock =  "<td>"+
                          "<button class='btn btn-success toggle-lock'>"+
                            "<input class='control-id' type='hidden' value='"+ v['id'] +"'>"+
                            "<i class='fas fa-lock-open' style='font-weight: bolder;color: #fff;'></i>"+
                          "</button>"+
                      "</td>";
          if ($('.active-access-id').val() == 2) {
            if (v['agent'] != 0) {
              controllerCol = "<td>"+
                                "<button class='btn btn-danger email-mod' ticket-id='"+v['ticket_code']+"' data-toggle='modal' data-target='modal-lg-email'>"+
                                  "<i class='fas fa-lock' style='font-weight: bolder;color: #fff;'></i>"+
                                "</button>"+
                            "</td>";
            }else{
              controllerCol = "<td>"+
                                "<button class='btn btn-primary email-mod' ticket-id='"+v['ticket_code']+"' data-toggle='modal' data-target='modal-lg-email'>"+
                                  "<i class='fas fa-lock-open' style='font-weight: bolder;color: #fff;'></i>"+
                                "</button>"+
                            "</td>";
            }
            
          }else{
            controllerCol = (v['is_lock'] == 1 ? lockBtn:unLock)
          }
          emailList.append(
            "<tr>"+
              "<td><a class='copy_text'  data-toggle='tooltip' title='Copy to Clipboard' href='"+v['ticket_code']+"'>"+v['ticket_code']+"</td>"+
              "<td>"+v['age']+"</td>"+
              "<td>"+v['create_dt']+"</td>"+
              "<td>"+v['close_dt']+"</td>"+
              "<td>"+v['state']+"</td>"+
              "<td>"+v['queue']+"</td>"+
              controllerCol+
            "</tr>"
          );
        });
        tblInitialize( 'emailTable', 5, 0, 'desc');
        $("#emailTable").DataTable().draw();
        $('.tbl-loader').hide();
      }
    });
  }
  
  

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
              "<td>"+v['remarks']+"</td>"+
              ($('.active-access-id').val() != 2 ? '<td>'+v['group_name']+'</td>' : '')+
              ($('.active-access-id').val() != 2 ? '<td>'+v['subgroup_name']+'</td>' : '')+
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

  
    
});