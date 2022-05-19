<div class="modal fade" id="modal-lg-form">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="form-list-title">Forms List</h4>
          <h4 class="modal-title" id="create-form-title" style="display: none">Upload Form </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- .modal-body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-2"><button class="btn btn-block folder" target="intake" type="1">Intake</button></div>
                <div class="col-md-2"><button class="btn btn-block folder" target="inhouse" type="2">Survey - Inhouse</button></div>
                <div class="col-md-2"><button class="btn btn-block folder" target="google" type="3">Survey - Google</button></div>
                <div class="col-md-2"><button class="btn btn-block folder" target="asses" type="4">Assesment</button></div>
                <div class="col-md-2"><button class="btn btn-block folder" target="eval" type="5">Evaluation</button></div>
                <div class="col-md-2"><button class="btn btn-block folder" target="session" type="6">Session</button></div>

                <div class="col-12 form-content">
                  <!-- <button class="btn btn-block btn-warning" id="create-form" style="color: #fff; font-weight: bolder">Create New Form</button> -->
                  <div class="card card-warning card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active main-tab" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Bio</a>
                        </li>
                        <li class="nav-item ml-auto">
                          <a class="nav-link" role="tab" id="createForm" style="cursor: pointer"><span><i class="nav-icon fas fa-plus"></i> Upload Form</span></a>
                          <a class="nav-link" role="tab" id="uploadForm" style="cursor: pointer"><span><i class="nav-icon fas fa-upload"></i> Upload Google Form</span></a>
                        </li>
                        <li class="nav-item ">
                          <a class="nav-link btn-back" role="tab" style="cursor: pointer"><span><i class="nav-icon fas fa-arrow-alt-circle-left" data-toggle="tooltip" data-placement="top" title="Back"></i></span></a>
                        </li>
                        
                      </ul>
                    </div>
                    <div class="card-body">
                      <table id="formsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>ID</th>
                          <th>Form name</th>
                          <th>Location</th>
                          <th>Author</th>
                          <th>Created On</th>
                        </tr>
                        </thead>
                        <tbody class="form-list">
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Form name</th>
                          <th>Location</th>
                          <th>Author</th>
                          <th>Created On</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card -->
                  </div>
                </div>
                <div class="col-12 create-form-content" style="display: none">
                  <!-- .form-title -->
                  <form action="{{ url('/uploadform') }}" id="uploadSurveyForm" method="POST" enctype="multipart/form-data">
                    <div class="upload-form row">
                      <div class="form-group">
                        <input class="control-id-create"  type="hidden" value="">
                        <input id="create-form-type"  type="hidden" value="">
                     </div>
                      <div class="form-group col-12">
                         <input class="form-control form-input-details" id="uploadSurveyTitle" type="text" placeholder="Form Title *" required>
                      </div>
                      <div class="form-group col-12">
                        <textarea class="form-control form-input-details" placeholder="Form Description" id="formDescription" ></textarea>
                      </div>
                      {{-- <div class="form-group col-md-6">
                        <select class="form-select form-control" id="uploadOption" required>
                          <option selected disabled>Upload Option *</option>
                          <option value="linkUpload">Link Upload</option>
                          <option value="fileUpload">File Upload</option>
                        </select>
                      </div> --}}
                      <div class="col-12 form-link-container">
                        {{-- <div class="form-group link-upload">
                          <input class="form-control form-input-details" id="createFormLink" type="text" placeholder="Form Link">
                        </div> --}}
                        
                        <div class="form-group file-upload">
                          <label class="custom-file-label" for="customFile">Choose file *</label>
                          <input type="file" class="custom-file-input form-input-details" required id="customFile" name="survey_form">
                        </div>
                      </div>
                    </div>
                  </form>
                  
                  
                  <!-- / Create Form Body -->

                </div>
                <div class="col-12 upload-google-form" style="display: none">
                  <!-- .form-title -->
                  <form action="" id="uploadGoogleForm" method="POST">
                    <div class="form-title col-12">
                      <div class="form-group">
                        <input class="control-id-google" type="hidden" value="">
                        <input id="googleFormType"  type="hidden" value="">
                     </div>
                      <div class="form-group">
                        <input class="form-control form-input-details" required type="text" placeholder="Form Title *" name="googleFormTitle" id="googleFormTitle">
                      </div>
                      <div class="form-group">
                        <textarea class="form-control form-input-details" placeholder="Form Description" name="googleFormDescription" id="googleFormDescription" ></textarea>
                      </div>
                      <div class="form-group">
                         <input class="form-control form-input-details" required type="url" name="googleFormLink" id="googleFormLink" placeholder="Google Form Link *">
                      </div>
                    </div>
                  </form>
                  
                  
                  <!-- / Create Form Body -->

                </div>
                

            </div>
        </div>
        <!-- / .modal-body -->
        <!-- modal-footer -->
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary form-btn" id="back-create-form">Back</button>
            <button type="button" class="btn btn-primary form-btn" id="uploadFormBtn">Upload</button>
            
        </div>
        <!-- / .modal-footer -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<script src="{{ asset('js/form.js') }}" defer></script>
<style>
    .folder {
        width: 150px;
        height: 105px;
        margin: 0 auto;
        margin-top: 50px;
        position: relative;
        background-color: #ffad31;
        border-radius: 0 6px 6px 6px;
        box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
        color: #fff;
    }

    .folder:before {
        content: '';
        width: 50%;
        height: 12px;
        border-radius: 0 20px 0 0;
        background-color: #ffad31;
        position: absolute;
        top: -12px;
        left: 0px;
        color: #fff;
    }

    .folder:hover{
        background-color: #b4b4b4;
        border-color: #b4b4b4;
        color: #fff;
        font-weight: bolder;
    }

    .create-form-header {
      height: 4rem;
    }

    hr.divider {
      border-top: 2px solid #bbb;
      border-radius: 5px;
    }

    .button-action {
      border-left: 2px solid #bbb;
    }

    .btn-create-form {
      border-radius: 50px;
    }

    #modal-lg-form .modal-dialog{
        overflow-y: initial !important
    }
    #modal-lg-form .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    #answer {
      width: 71%;
      margin-top: 10px;
    }
    
    #answer .form-check {
      padding:0;
    }

    .custom-input {
      border-top: 0;
      border-right: 0;
      border-left: 0;
    }

    .custom-input:focus-visible {
      outline: none;
      border-bottom: 3px solid #fd7e14;
    }

    .removeCancelButton {
      display: none;
      visibility: hidden;
      pointer-events: none;
    }

    .custom-span {
      border-bottom: 2px solid #bbb;
      color: #5d5b5b;
      cursor: pointer;
    }

    .custom-span:hover {
      border-bottom: 2px solid #fd7e14;
      color: #17a2b8;
      cursor: pointer;
    }

    .hidden {
      display: none !important;
    }
</style>