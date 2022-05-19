<div class="modal fade" id="modal-lg-add-user">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        @include('includes.defaultloader')
        <div class="modal-header">
          <h4 class="modal-title user-mgt-title">Create User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="newuserform" action="/new-user" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="activeId" class="active-id">
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full Name</label>
                                <input type="text" name="fullname" class="form-control frm-user text-only">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Call Sign</label>
                                <input type="text" name="callsign" class="form-control frm-user text-only">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control frm-user">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Support</label>
                                <select name="emailsupport" class="form-control frm-user dd-is-email">
                                    <option value="">Please Choose 1</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Access Level</label>
                                <select name="accesslevel" class="form-control frm-user dd-access-level">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Position</label>
                                <select  name="position" class="form-control dd-position frm-user">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Location</label>
                                <select name="location" class="form-control dd-loc frm-user">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Group</label>
                                <select name="group" class="form-control dd-group frm-user" disabled>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hire Date</label>
                                <input type="date" name="hiredate" class="form-control frm-user input-hire">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Team Lead</label>
                                <select  name="teamlead" class="form-control frm-user dd-team-lead">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Manager</label>
                                <select name="manager" class="form-control frm-user dd-manager">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status</label>
                                <select  name="status" class="form-control dd-user-status">
                                    <option value="1" selected>Active</option>
                                    <option value="0" selected>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default btn-close-user-mod" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-new">Register</button>
            <button type="submit" class="btn btn-primary btn-add-update" style="display: none">Update</button>
            </div>
      </div>
    </div>
</div>
