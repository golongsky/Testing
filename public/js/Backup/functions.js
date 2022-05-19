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
    if (_replace != 0) {
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