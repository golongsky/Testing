function hide_side_bar(){
    $('.burger-bars')[0].click();
}

function togglevisible( _targetTable, _action ){
    if (_action == 'show') {
        _targetTable.show();
    }else{
        _targetTable.hide();
    }
    
}

function emptyDestroy(_targetTable, _action){
    if (_action == 'destroy') {
        _targetTable.DataTable().destroy();
    }else{
        _targetTable.empty();
    }
    
}

function valremovereplace( _targetTable, newVal ){
    if (newVal != 0) {
        _targetTable.val("").val(newVal);
    }else{
        _targetTable.val("");
    }
}

function htmlcontrol( _target, _append ){
    if (_append == "") {
        _target.html("");
    }else{
        _target.html("").append(_append);
    }
    
}


function tblInitialize( _table, _plength, _colsorting, _sorting){
    $("#"+_table).DataTable({
        "pageLength": _plength,
        "responsive": true,
        "autoWidth": false, 
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "scrollX": true,
        "order": [[ _colsorting, _sorting ]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    }).buttons().container().appendTo('#'+_table+'_wrapper .col-md-6:eq(0)');
}

function formSubmit( _table, _errormsg){
    var frm = $('#'+_table);
    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: frm.attr('action'),
            data: { 
                formdata : frm.serialize(), 
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                toastr.success(_sucessmsg);
                loadUsers();
            },
            error: function (data) {
                toastr.danger(_errormsg);
            },
        });
    });
}





// STATIC FUNCTION (For specific use only)
function checkMyLockedTicket(){
    console.log($('.copy_text').html());
    $.ajax({
      type: "POST",
        url: "checklock",
        data: {"email_ticket_no": $('.copy_text').html(),
              _token: $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
      success: function (response) {
        console.log(response.data);
        if (response.data == false) {
            emptyDestroy( $('.tbody-email'), 'empty');
            setTimeout(function() {
                loadEmailList();
            }, 3000);
          
        }
      }
    });
}


function loadEmailList( _emp = ""){

    emptyDestroy( $('#emailTable'), 'destroy');
    var emailList = $('.tbody-email');
    emptyDestroy( $('.tbody-email'), 'empty');
    $.ajax({
      type: "GET",
      url: "emailist",
      success: function (response) {
        console.log(response.data);
        if ($('.active-access-id').val() == 2) {
            if (response.data == 0) {
                emailList.append(
                    "<tr>"+
                      "<td colspan='6' style='text-align: center; font-weight: bolder'>No Tickets Available!! Please Wait!!</td>"+
                    "</tr>"
                );
                document.getElementById("startbtn").style.display = "none";
            } else {
                if (typeof response.data[0] === "undefined") {
                    $('.empty-handler').remove();
                    emailList.append(
                        "<tr>"+
                          "<td><a class='copy_text'  data-toggle='tooltip' title='Copy to Clipboard' href='"+response.data['ticket_code']+"'>"+response.data['ticket_code']+"</td>"+
                          "<td>"+response.data['age']+"</td>"+
                          "<td>"+response.data['create_dt']+"</td>"+
                          "<td>"+response.data['close_dt']+"</td>"+
                          "<td>"+response.data['state']+"</td>"+
                          "<td>"+response.data['queue']+"</td>"+
                        "</tr>"
                    );
                }else{
                    $('.empty-handler').remove();
                    emailList.append(
                        "<tr>"+
                          "<td><a class='copy_text'  data-toggle='tooltip' title='Copy to Clipboard' href='"+response.data[0]['ticket_code']+"'>"+response.data[0]['ticket_code']+"</td>"+
                          "<td>"+response.data[0]['age']+"</td>"+
                          "<td>"+response.data[0]['create_dt']+"</td>"+
                          "<td>"+response.data[0]['close_dt']+"</td>"+
                          "<td>"+response.data[0]['state']+"</td>"+
                          "<td>"+response.data[0]['queue']+"</td>"+
                        "</tr>"
                    );
                }
                document.getElementById("startbtn").style.display = "show";
            }
        }else{
            var controllerCol  = "";
                
            $.each(response.data,function(k,v){
                var lockBtn =  "<td>"+
                                    "<button class='btn btn-danger toggle-lock'>"+
                                    "<input class='control-id' type='hidden' value='"+ v['id'] +"'>"+
                                    "<i class='fas fa-lock' style='font-weight: bolder;color: #fff;'></i>"+
                                    "</button>"+
                                "</td>",
                    unLock  =  "<td>"+
                                "<button class='btn btn-success toggle-lock'>"+
                                    "<input class='control-id' type='hidden' value='"+ v['id'] +"'>"+
                                    "<i class='fas fa-lock-open' style='font-weight: bolder;color: #fff;'></i>"+
                                "</button>"+
                            "</td>";
                controllerCol = (v['is_lock'] == 1 ? lockBtn:unLock)
                emailList.append(
                    "<tr>"+
                      "<td><a class='copy_text'  data-toggle='tooltip' title='Copy to Clipboard' href='"+v['ticket_code']+"'>"+v['ticket_code']+"</td>"+
                      "<td>"+v['age']+"</td>"+
                      "<td>"+v['create_dt']+"</td>"+
                      "<td>"+v['close_dt']+"</td>"+
                      "<td>"+v['state']+"</td>"+
                      "<td>"+v['queue']+"</td>"+
                      "<td>"+(v['agent'] == 0 ? "--" : v['uName'])+"</td>"+
                      "<td>"+(v['meta_state'] == null ? "--" : v['meta_state'])+"</td>"+
                      "<td>"+(v['csName'] == null ? "--" : v['csName'])+"</td>"+
                      "<td>"+(v['cName'] == null ? "--" : v['cName'])+"</td>"+
                      controllerCol+
                    "</tr>"
                );
            });
            
            
        }
        if (response.data != 0 || _emp == 1) {
            tblInitialize( 'emailTable', 5, 1, 'desc');
            $("#emailTable").DataTable().draw();
            
        }
        $('.tbl-loader').hide();
      }
    });
  }

  function pullLastUploadId(){
    $.ajax({
        type: "GET",
        url: "pulllastupload",
        success: function (response) {
            $('.btn-delete-record').attr('target-value',response.data);
        }
      });
  }