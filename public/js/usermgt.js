$(document).ready(function() {

    $('.add-new-user-modal').on("click", function() { clearfields(); $('.user-form-loader').hide(); });
    
    function loadgroup( _locationId , _selected = 0){
        console.log(_locationId);
        var ddGroup = $('.dd-group');
        ddGroup.empty();
        ddGroup.append("<option value='0'>Select Group</option>");
        if (_locationId != 0) {
            $.ajax({
                type: "POST",
                url: "fill-group",
                data: {
                    "locationId" : _locationId,
                    _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                success: function (response) {
                    $.each(response.grp,function(k,v){
                        ddGroup.append("<option value='"+v['id']+"'>"+v['subgroup_name']+"</option>");
                    });
                    ddGroup.attr('disabled', false);
                    if (_selected != 0) {
                        $('.dd-group').val(_selected);
                    }                    
                }
            });
        }else{
            ddGroup.attr('disabled', true);
            return false;
        }
    }

    $('select.dd-loc').on('change', function(){
        loadgroup( $(this).val(), 0);
    });
    loadUsers();
    function loadUsers(){
        $('#userTable').DataTable().destroy();
        var userList = $('.user-list');
        $.ajax({
            type: "GET",
            url: "all-user",
            success: function (response) {
                userList.empty();
                console.log(response);
                $.each(response.data,function(k,v){
                    btnreq ="<button type='button' class='btn btn-warning user-update' style='margin-right: 5px' target-id='"+v['id']+"' data-toggle='modal' data-target='#modal-lg-add-user'>"+
                                "<i class='nav-icon fas fa-pen-nib'></i>"+
                            "</button>"+
                            "<button type='button' class='btn btn-danger user-delete' target-id='"+v['id']+"'>"+
                                "<i class='nav-icon fas fa-eraser'></i>"+
                            "</button>";
                    userList.append(
                        "<tr>"+
                            "<td>"+v['id']+"</td>"+
                            "<td>"+v['name']+"</td>"+
                            "<td>"+(v['call_sign'] == null ? '--' : v['call_sign'])+"</td>"+
                            "<td>"+v['email']+"</td>"+
                            "<td>"+(v['group_name'] == null ? '--' : v['group_name'])+"</td>"+
                            "<td>"+(v['subgroup_name'] == null ? '--' : v['subgroup_name'])+"</td>"+
                            "<td>"+(v['is_active'] == 1 ? 'Active' : 'Inactive')+"</td>"+
                            "<td>"+
                            btnreq+
                            "</td>"+
                        "</tr>"
                    );
                });
                tblReload( 'userTable' )
            }
        });
    };


    function tblReload( _table){
        $("#"+_table).DataTable({
            "pageLength": 5,
            "responsive": true,"autoWidth": false, 
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "scrollX": true,
            "order": [[ 0, "desc" ]],
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

    function clearfields(){
        $('.frm-user').val("");
        $('.dd-user-status').val(1);
        $('.dd-access-level').empty().append("<option value='0'>Select Access Level</option>");
        $('.dd-position').empty().append("<option value='0'>Select Position</option>");
        $('.dd-loc').empty().append("<option value='0'>Select Location</option>");
        $('.dd-group').empty().append("<option value='0'>Select Group</option>").attr('disabled', true);
        $('.dd-team-lead').empty().append("<option value='0'>Select Team Lead</option>");
        $('.dd-manager').empty().append("<option value='0'>Select Manager</option>");
        $('.user-mgt-title').html("").html("Create User");
        pullData();
    }

    function pullData(){
        $.ajax({
            type: "GET",
            url: "fill-dropdown",
            success: function (response) {
                console.log(response);
                $.each(response.role,function(k,v){
                    $('.dd-access-level').append("<option value='"+v['id']+"'>"+v['role_name']+"</option>");
                });
                $.each(response.post,function(k,v){
                    $('.dd-position').append("<option value='"+v['id']+"'>"+v['position_name']+"</option>");
                });
                $.each(response.loct,function(k,v){
                    $('.dd-loc').append("<option value='"+v['id']+"'>"+v['group_name']+"</option>");
                });
                $.each(response.tls,function(k,v){
                    $('.dd-team-lead').append("<option value='"+v['id']+"'>"+v['name']+"</option>");
                });
                $.each(response.mng,function(k,v){
                    $('.dd-manager').append("<option value='"+v['id']+"'>"+v['name']+"</option>");
                });
            }
        });
    }

    

    
    $('.text-only').keydown(function(e) {
        if (e.ctrlKey || e.altKey) {
          e.preventDefault();
        } else {
          var key = e.keyCode;
          if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
          }
        }
    });


    var frm = $('#newuserform');

    frm.submit(function (e) {

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: frm.attr('action'),
            data: { 
                    formdata : frm.serialize(), 
                    _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.validator == 'create') {
                    toastr.success('New user successfully added.');
                }else if (data.validator == 'update') {
                    toastr.warning('User successfully updated.');
                }else{
                    toastr.danger('ERROR!! Please contact you Admin.');
                    return false;
                }

                loadUsers();
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
                toastr.danger('Something went wrong! PLease contact your system administrator!');
            },
        });
    });

    $(document).on("click",".btn-add-new",function() {
        $('.btn-add-new').show();
        $('.btn-add-update').hide();
    });

    $(document).on("click",".user-update",function() {
        var t_id = $(this).attr('target-id');
        $('.user-form-loader').show();
        clearfields();
        $('.user-mgt-title').html("").html("Update User");
        $('.btn-add-new').hide();
        $('.btn-add-update').show();
        $('.active-id').val(t_id);
        
        $.ajax({
            type: "POST",
            url: "new-user-data",
            data: {
                "tId" : t_id,
                _token: $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (response) {
                console.log(response.data);
                loadgroup( response.data['user_group'] , response.data['sub_group']);
                $('#newuserform').removeAttr('action').attr('action', "/update-user");
                

                $('input[name$="fullname"]').val(response.data['name']);
                $('input[name$="callsign"]').val(response.data['call_sign']);
                $('input[name$="email"]').val(response.data['email']);
                $('.dd-is-email').val(response.data['is_email']);
                $('.dd-access-level').val(response.data['access_level']);
                $('.dd-position').val(response.data['position']);
                $('.dd-loc').val(response.data['user_group']);
                // $('.dd-group').val(response.data['sub_group']);
                $('input[name$="hiredate"]').val(response.data['hire_date'].substr(0,response.data['hire_date'].indexOf(' ')));
                $('.dd-team-lead').val(response.data['tl_id']);
                $('.dd-manager').val(response.data['sm_id']);
                $('.dd-user-status').val(response.data['is_active']);
            }
        });
        setTimeout(function() {
            $('.user-form-loader').hide();
                toastr.success('User details Loaded.');
        }, 3000);
    });

    $(document).on("click",".user-delete",function() {
        var t_id = $(this).attr('target-id');
        $('.user-form-loader').show();
        $.ajax({
            type: "POST",
            url: "delete-user",
            data: {
                "tId" : t_id,
                _token: $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (response) {
                console.log(response.status);
                toastr.success('User Deleted.');
                loadUsers();
            }
        });
        setTimeout(function() {
            $('.user-form-loader').hide();
                toastr.success('User details Loaded.');
        }, 3000);
    });
    
    $('.btn-close-user-mod').on("click",function() {
        clearfields();
    });
});


