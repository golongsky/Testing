<div class="content-wrapper" style="min-height: 480px !important">
    <section class="content" style="margin-top: 5px">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-block btn-primary add-new-user-modal" data-toggle="modal" data-target="#modal-lg-add-user">Add New User</button>
              </div>
              <div class="card-body">
                @include('includes.defaultloader')
                <table id="userTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Full Name</th>
                    <th>Call Sign</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Group</th>
                    <th>Status</th>
                    <th>Controls</th>
                  </tr>
                  </thead>
                  <tbody class="user-list">
                  
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Full Name</th>
                      <th>Call Sign</th>
                      <th>Email</th>
                      <th>Location</th>
                      <th>Group</th>
                      <th>Status</th>
                      <th>Controls</th>
                    </tr>
                  </tfoot>
                </table>
              </div>           
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('modals.userform')
  <script src="{{ asset('js/usermgt.js') }}" defer></script>
