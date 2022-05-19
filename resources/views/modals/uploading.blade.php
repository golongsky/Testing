<div class="modal fade modal-upload" tabindex="-1" role="dialog" aria-labelledby="modalUpload" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="form-upload-preloader" style="
          height: 100%;
          width: 100%;
          background-color: #ffffff;
          position: absolute;
          z-index: 100;
          display: none;
      ">
        <img class="animation__wobble" src="dist/img/userloader.gif" alt="AdminLTELogo" height="60" width="60" style="
        position: absolute;
        top: 35%;
        left: 50%;
    ">
    </div>
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Raw Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="uploadExcelForm" method="post" action="{{ url('/import') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="file" id="file" required>
            <a href="{{ url('/sample/Testingdata.xlsx') }}">Download Template</a>
          </form>
            

            
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary btn-back" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadExcel">Upload</button>
        </div>
      </div>
    </div>
  </div>
