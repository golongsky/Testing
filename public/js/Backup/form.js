$(document).ready(function() {
    var counter = 1,
        _formType = '',
    // validate uploading of google form
        uploadGoogleFormValidator = $("#uploadGoogleForm").validate({debug: true}),
        uploadSurveyFormValidator = $("#uploadSurveyForm").validate();




    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });


    $('.form-content, .form-btn').hide();
    $('.folder').show();
    $('.folder').on("click", function() {
        $("#createForm, #uploadForm").show();
        var _target = $(this).attr('target'),
            _content = $(this).html(),
            _formBtn = $(".form-btn").hide();
        
        _formType = $(this).attr("type");
        loadForms(_formType);
        $('.folder').hide();
        $('.form-content').show();

        $('.main-tab').html(_content);

        if(_content == "Survey - Google") {
            $("#googleFormType").val(_formType);
            $("#createForm").hide();
        } else {
            $("#create-form-type").val(_formType);
            $("#uploadForm").hide();
        }
    });

    $('.btn-back').on("click", function() {
        $('.form-content').hide();
        $('.folder').show();
    });

    // $("#formsTable").DataTable({
    //     "responsive": true, "lengthChange": true, "autoWidth": false, "lengthMenu": [[6, 10, 15, 20], [6, 10, 15, 20]],
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //     "responsive": true,
    //     "order": [[ 0, "desc" ]]
    //   }).buttons().container().appendTo('#formsTable_wrapper .col-md-6:eq(0)');

    $("#createForm").on("click", function() {
        $('.form-content, #form-list-title').hide();
        $(".create-form-content, #back-create-form, #create-form-title, #create-form-btn, #uploadFormBtn").show();
        $(".control-id-create").val(Math.random().toString(36).substr(2, 10));
    });

    $("#uploadForm").on("click", function() {
        $('.form-content, #form-list-title').hide();
        $(".upload-google-form, #back-create-form, #uploadFormBtn, #uploadGoogleForm, #create-form-title").show();
        $(".control-id-google").val(Math.random().toString(36).substr(2, 10));
    });

    $(document).on("click","#uploadFormBtn", function(){
        if(_formType == 3) {
            uploadGoogleFormValidator.element("#googleFormLink");
            uploadGoogleFormValidator.element("#googleFormTitle");
            ($("#uploadGoogleForm").valid() == false ? "":$("#uploadGoogleForm").submit());
        } else {
            uploadSurveyFormValidator.element("#uploadSurveyTitle");
            uploadSurveyFormValidator.element("#formDescription");
            uploadSurveyFormValidator.element("#customFile");
            console.log($("#customFile").val());
            // uploadSurveyFormValidator.element("#createFormLink");
            // uploadSurveyFormValidator.element("#customFile");
            ($("#uploadSurveyForm").valid() == false ? "":$("#uploadSurveyForm").submit());
        }
    });



    $("#back-create-form").on("click", function() {
        $('.form-content, #form-list-title').show();
        $(".create-field-container").html("");
        $(".form-input-details").val("");
        $(".create-form-content, .upload-google-form, #back-create-form, #create-form-btn, #create-form-title, #upload-google-title, #uploadGoogleForm, #uploadFormBtn").hide();
        var uploadGoogleField = ["#googleFormTitle", "#googleFormLink", ".control-id-google", "#googleFormType", "#googleFormDescription"];
        fieldReset(uploadGoogleField);
        $(".control-id-create, .control-id-google").val("");
        loadForms(_formType);
    });

    $(document).on("click",".btn-create-question", function() {
        $(this).attr("disabled", "disabled");
        addQuestion();
    });

    $(document).on("click",".btn-remove-question", function() {
        var parent = $(this).parents(".create-form-body"),
            parentId = $(parent).prop("id"),
            hasNextSibling = $(parent).next(),
            prevQuestionContainer = $(parent).prev().find(".btn-create-question");
        if( hasNextSibling.length == 0) {
            $(prevQuestionContainer).removeAttr("disabled");
        };
        
        // (hasNextSibling.length == 0 ? $(prevQuestionContainer).removeAttr("disabled"):"");

        if(parentId == 1) {
            $(parent).prop('disabled', true);
            $(this).removeClass("btn-danger").addClass("btn-secondary");
        } else {
            $(parent).remove();
        }
    });

    // add choice option action
    $(document).on("click", ".add-option", function(){
        var answerContainer = $(this).parents(".answer-container").prop("id"),
            fieldType = $(this).prev().prop("type"),
            container = $(this).parent().remove();
        addOption(container= answerContainer, fieldType= fieldType);
        

    });


     // add field type

     $(document).on("change", ".fieldType", function() {
        var parent = $(this).parents(".create-form-body"),
            parentId = $(parent).prop("id"),
            childAnswerContainer = $(parent).find('[id*="answer'+parentId+'"]').prop("id"),
            value = $(this).val();
        createField(value, childAnswerContainer);
    });


    // save google form
    $("#uploadGoogleForm").on("submit", function(e) {
        e.preventDefault();
        var formTitle = $("#googleFormTitle").val(),
            formLink = $("#googleFormLink").val(),
            formControlId = $(".control-id-google").val(),
            formType = $("#googleFormType").val(),
            formDescription = ($("#googleFormDescription").val() == "" ? " ": $("#googleFormDescription").val());
            
            $.ajax({
                type: "POST",
                url: "new-form",
                data: {
                    "form_name"           : formTitle,
                    "form_type"           : formType,
                    "form_description"    : formDescription,
                    "form_control_id"     : formControlId,
                    "form_link"           : formLink,
                    _token: $('meta[name="csrf-token"]').attr('content')
                  },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    $(".form-input-details").val("");
                    $("#back-create-form").trigger("click");
                    toastr.success('New Form Successfully Created!');
                },
                error: function (response) {
                    console.log(response)
                    var errorStatusText = response.statusText;
                    var errorStatusCode = response.status
                    toastr.error(errorStatusCode + " : " + errorStatusText );
                }
              });
    });

    
    // $(document).tooltip({selector: '[data-toggle="tooltip"]'});

    // add option or others
    function addOptionOthers(params) {

    };



    // add field
    function createField(fieldType, targetAnswerContainer) {
        var formCheck = "<div class='mt-3 form-check-"+targetAnswerContainer+"'></div>",
            formCheckId = ".form-check-"+targetAnswerContainer,
            addOptionContainer = "<div class='mt-3  add-option-"+targetAnswerContainer+"'></div>",
            addOptionId = ".add-option-"+targetAnswerContainer,
            answerContainerClass = "#" +targetAnswerContainer;
        switch (fieldType) {
            case "input":
                $(".added-field-"+targetAnswerContainer).remove();
                $(".form-check-"+targetAnswerContainer).remove();
                $(answerContainerClass).append($(formCheck).append("<input type='text' class='form-control added-field-"+targetAnswerContainer+"' placeholder='Answer'>"));
                
                break;
            case "paragraph":
                $(".added-field-"+targetAnswerContainer).remove();
                $(".form-check-"+targetAnswerContainer).remove();
                $(answerContainerClass).append($(formCheck).append("<textarea class='form-control added-field-"+targetAnswerContainer+"' placeholder='Answer' ></textarea>"));
                break;
            case "multiple":
                $(".added-field-"+targetAnswerContainer).remove();
                $(addOptionId).remove();
                $(formCheckId).remove();
                $(answerContainerClass).append($(formCheck).append("<input type='radio' name='radio_name' class='added-field-"+targetAnswerContainer+"' disabled/> <input type='text' class='custom-input added-field-"+targetAnswerContainer+"' >"));
                $(answerContainerClass).append($(addOptionContainer).append("<input type='radio' name='radio_name' class='added-field-"+targetAnswerContainer+"' disabled/> <span type='text' class='custom-span added-field-"+targetAnswerContainer+" add-choice-option-"+targetAnswerContainer+" add-option'>Add option</span> or <span type='text' class='custom-span added-field-"+targetAnswerContainer+" add-choice-others-"+targetAnswerContainer+" add-other'>Add 'other'</span>"));
                break;
            case "checkbox":
                $(".added-field-"+targetAnswerContainer).remove();
                $(addOptionId).remove();
                $(formCheckId).remove();
                $(answerContainerClass).append($(formCheck).append("<input type='checkbox' class='added-field-"+targetAnswerContainer+"' disabled/> <input type='text' class='custom-input added-field-"+targetAnswerContainer+"' >"));
                $(answerContainerClass).append($(addOptionContainer).append("<input type='checkbox' class='added-field-"+targetAnswerContainer+"' disabled/> <span type='text' class='custom-span added-field-"+targetAnswerContainer+" add-check-option-"+targetAnswerContainer+" add-option'>Add option</span> or <span type='text' class='custom-span added-field-"+targetAnswerContainer+" add-check-others-"+targetAnswerContainer+" add-other'>Add 'other'</span>"));
                break;
        };
    };


    // add function choices/checkbox options 
    function addOption(container, fieldType) {
        counter++;
        var formCheck = "<div class='mt-3 form-check-"+container+"'></div>",
            addOptionContainer = "<div class='mt-3  add-option-"+container+"'></div>",
            mainContainer = $("#"+container);
        if(fieldType == "checkbox"){
            mainContainer.append($(formCheck).append("<input type='checkbox' class='added-field-"+container+"' disabled/> <input type='text' class='custom-input added-field-"+container+"' >"));
            mainContainer.append($(addOptionContainer).append("<input type='checkbox' class='added-field-"+container+"' disabled/> <span type='text' class='custom-span added-field-"+container+" add-check-option-"+container+" add-option'>Add option</span> or <spantype='text' class='custom-span added-field-"+container+" add-check-others-"+container+"'>Add 'other'</span>"))
        } else {
            mainContainer.append($(formCheck).append("<input type='radio' name='radio_name' class='added-field-"+container+"' disabled/> <input type='text' class='custom-input added-field-"+container+"' >"));
            mainContainer.append($(addOptionContainer).append("<input type='radio' name='radio_name' class='added-field-"+container+"' disabled/> <span type='text' class='custom-span added-field-"+container+" add-choice-option-"+container+" add-option'>Add option</span> or <spantype='text' class='custom-span added-field-"+container+" add-choice-others-"+container+"'>Add 'other'</span>"))
        }
    };

    function fieldReset(element) {
        $.each(element, function(key, value){
            if ($(value).hasClass('error')) {
                $(value).removeClass("error");
                $(value).siblings('.error').remove();
            }
        });
        
    };
    function loadForms(_form_type){
        $('#formsTable').DataTable().destroy();
        var form = $('.form-list');
        $.ajax({
            type: "GET",
            url: "pull-form",
            data: {
                "form_type" : _form_type,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                form.empty();
                $.each(response.data,function(index, value){
                    count = index + 1;
                    form.append(
                        "<tr>"+
                            "<td>"+ count +"</td>"+
                            "<td>"+  value['form_name'] +"</td>"+
                            "<td>"+  value['form_created_by'] +"</td>"+
                            "<td>"+  value['name'] +"</td>"+
                            "<td>"+  value['created_at'] +"</td>"+
                        "</tr>"
                    );
                });
                formDatatable("formsTable");
            },
            error: function (response) {
                console.log("<<<<<<<<<<<<<<<<<<<<<<<")
                console.log(response);
            }
        });
    };

    function formDatatable(_table) {
        $("#"+ _table).DataTable({
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
          }).buttons().container().appendTo('#' + _table + '_wrapper .col-md-6:eq(0)');
    }

});