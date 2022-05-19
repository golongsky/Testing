<div class="modal fade" id="modalGoal">
    <div class="modal-dialog modal-xl">
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
          <h4 class="modal-title">Coaching Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <div class="card card-warning card-outline card-tabs tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-coaching-tab" data-toggle="pill" href="#coachingDetails" role="tab" aria-controls="custom-tabs-coaching" aria-selected="false">Coaching Logs</a>
                    </li>
                    <li class="nav-item  ml-auto">
                      <a class="nav-link btn-goal-back float-right" role="tab" style="cursor: pointer; font-size: 20px"><span><i class="nav-icon fas fa-arrow-alt-circle-left" data-toggle="tooltip" data-placement="top" title="Back"></i></span></a>
                      <a class="nav-link milestone-btn float-right" id="backMilestoneArrow" role="tab" style="cursor: pointer; font-size: 20px"><span><i class="nav-icon fas fa-arrow-alt-circle-left" data-toggle="tooltip" data-placement="top" title="Back"></i></span></a>
                      <a class="nav-link feedback-btn float-right" id="backFeedbackArrow" role="tab" style="cursor: pointer; font-size: 20px"><span><i class="nav-icon fas fa-arrow-alt-circle-left" data-toggle="tooltip" data-placement="top" title="Back"></i></span></a>
                    </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="coachingDetailsAgent" role="tabpanel" aria-labelledby="custom-tabs-coaching-tab">
                    <div class="row">
                      <div class="col-12">
                          <div class="card-body">
                              <div class="coaching-table-container">
                                <table id="coachingDetailsTable" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Progress</th>
                                    <th>Title</th>
                                    <th>Details</th>
                                    <th>Goal</th>
                                    <th>Information</th>
                                  </tr>
                                  </thead>
                                  <tbody class="coaching-details-log-agent-list">
                                  
  
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Progress</th>
                                    <th>Title</th>
                                    <th>Details</th>
                                    <th>Goal</th>
                                    <th>Information</th>
                                  </tr>
                                  </tfoot>
                                </table>
                              </div>
                              <div class="goal-details">
                                @if(Auth::user()->access_level == 2 || Auth::user()->access_level == 4)
                                  <a class="nav-link btn-add-goal float-right btn btn-primary mb-3" role="tab" style="cursor: pointer;"><span><i class="nav-icon fas fa-plus"></i>  Create Goal</span></a>
                                  <a class="nav-link btn-add-milestone float-right btn btn-primary mb-3" role="tab" style="cursor: pointer;"><span><i class="nav-icon fas fa-plus"></i>  Create Milestone</span></a>
                                  @endif
                                <table id="coachingDetailsGoal" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Goal</th>
                                    <th>Progress</th>
                                    <th>Milestone</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody class="goal-log-agent">
                                    
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>ID</th>
                                    <th>Goal</th>
                                    <th>Progress</th>
                                    <th>Milestone</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                  </tr>
                                  </tfoot>
                                </table>
                              </div>
                              @if(Auth::user()->access_level == 2)
                              <div class="goal-form-agent agent-form">
                                @include('includes.goalform')
                              </div>
                              <div class="milestone-form-agent agent-form">
                                @include('includes.milestoneform')
                              </div>
                              <div class="show-milestone-agent agent-form">
                                @include('includes.milestone')
                              </div>
                              <div class="show-feedback-agent agent-form">
                                @include('includes.feedback')
                              </div>
                              <div class="feedback-form-agent agent-form">
                                @include('includes.feedbackform')
                              </div>
                              @endif
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            
          </div>
        </div>
        <!-- / .modal-body -->
        <!-- modal-footer -->
        <div class="modal-footer justify-content-between">
          {{-- Create Goal --}}
          <button type="button" class="btn btn-secondary goal-btn" id="backGoal">Back</button>
          <button type="button" class="btn btn-primary goal-btn" id="createGoal">Create</button>
          <button type="button" class="btn btn-primary" id="updateGoal">Update</button>
  
          {{-- Create Milestone --}}
          <button type="button" class="btn btn-secondary milestone-btn" id="backMilestone">Back</button>
          <button type="button" class="btn btn-primary milestone-btn" id="createMilestone">Create</button>
          <button type="button" class="btn btn-primary" id="updateMilestone">Update</button>
  
          {{-- Feedback --}}
          <button type="button" class="btn btn-secondary feedback-btn" id="backFeedback">Back</button>
          <button type="button" class="btn btn-primary feedback-btn" id="createFeedback">Create</button>
          <button type="button" class="btn btn-primary" id="updateFeedback">Update</button>
        </div>
      </div>
        <!-- / .modal-footer -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
    $(document).ready(function() {
      $( ".tabs" ).tabs();
    });
  </script>
  