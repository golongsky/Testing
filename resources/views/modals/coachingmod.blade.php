<div class="modal fade" id="modal-lg-agent">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agent: John Doe</h4>
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
                    <a class="nav-link" id="custom-tabs-bio-tab" data-toggle="pill" href="#custom-tabs-bio" role="tab" aria-controls="custom-tabs-bio" aria-selected="true">Bio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-coaching-tab" data-toggle="pill" href="#custom-tabs-coaching" role="tab" aria-controls="custom-tabs-coaching" aria-selected="false">Coaching Logs</a>
                  </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fad" id="custom-tabs-bio" role="tabpanel" aria-labelledby="custom-tabs-bio-tab">
                  @include('includes.bioagent')
                </div>
                <div class="tab-pane fade show active" id="custom-tabs-coaching" role="tabpanel" aria-labelledby="custom-tabs-coaching-tab">
                  <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <div class="coaching-table-container">
                              <table id="coachingAgentTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Date</th>
                                  <th>Progress</th>
                                  <th>Title</th>
                                  <th>Details</th>
                                  <th>Goal</th>
                                  <th>Status</th>
                                </tr>
                                </thead>
                                <tbody class="coaching-agent-log">
                                

                                </tbody>
                                <tfoot>
                                <tr>
                                  <th>ID</th>
                                  <th>Date</th>
                                  <th>Progress</th>
                                  <th>Title</th>
                                  <th>Details</th>
                                  <th>Goal</th>
                                  <th>Status</th>
                                </tr>
                                </tfoot>
                              </table>
                            </div>
                            <div class="goal-details">
                              @if(Auth::user()->access_level == 2 || Auth::user()->access_level == 4)
                                <a class="nav-link btn-add-goal float-right btn btn-primary mb-3" role="tab" style="cursor: pointer;"><span><i class="nav-icon fas fa-plus"></i>  Create Goal</span></a>
                                <a class="nav-link btn-add-milestone float-right btn btn-primary mb-3" role="tab" style="cursor: pointer;"><span><i class="nav-icon fas fa-plus"></i>  Create Milestone</span></a>
                                @endif
                              <table id="coachingAgentGoal" class="table table-bordered table-striped">
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
                                <tbody class="goal-log">
                                  
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
                            @if(Auth::user()->access_level == 4)
                            <div class="goal-form">
                              @include('includes.goalform')
                            </div>
                            <div class="milestone-form">
                              @include('includes.milestoneform')
                            </div>
                            <div class="show-milestone">
                              @include('includes.milestone')
                            </div>
                            <div class="show-feedback">
                              @include('includes.feedback')
                            </div>
                            <div class="feedback-form">
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
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  $(document).ready(function() {
    $( ".tabs" ).tabs();
  });
</script>
