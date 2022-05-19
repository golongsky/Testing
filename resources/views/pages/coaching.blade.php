<div class="content-wrapper" style="min-height: 480px !important">
    <section class="content" style="margin-top: 5px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                          @if(Auth::user()->access_level != 2)
                            <button class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-lg-form">Create Forms</button>
                          @else
                            <h3>My Coaching Log</h3>
                          @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          @if(Auth::user()->access_level != 2)
                            <table id="agentTbl" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                                <th>ID</th>
                                <th>Agent</th>
                                <th>Team Lead/ Coach</th>
                              </tr>
                              </thead>
                              <tbody>
                                @foreach ($agent_list as $agent)
                                <tr>
                                  <td>{{ $agent->agent_id }}</td>
                                    <td>
                                      <span class="coach-mod" target-id="{{ $agent->agent_id }}" data-toggle="modal" data-target="#modal-lg-agent" style="cursor: pointer; color: #17a2b8 !important">{{ $agent->agent }} </span>
                                    </td>
                                    <td>
                                      <span target-id="{{ $agent->tl_id }}" data-toggle="modal" data-target="#modal-lg-coach" style="cursor: pointer; color: #17a2b8 !important">{{ $agent->tl }}</span>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                              <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Agent</th>
                                <th>team Lead/Coach</th>
                              </tr>
                              </tfoot>
                            </table>
                          @else
                          <table id="example3" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Date</th>
                              <th>Progress</th>
                              <th>Title</th>
                              <th>Details</th>
                              <th>Information</th>
                              <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($agent_list as $agent)
                              <tr>
                                <td>{{ $agent->agent_id }}</td>
                                  <td>
                                    <span class="coach-mod" target-id="{{ $agent->agent_id }}" data-toggle="modal" data-target="#modal-lg-agent" style="cursor: pointer; color: #17a2b8 !important">{{ $agent->agent }} </span>
                                  </td>
                                  <td>
                                    <span target-id="{{ $agent->tl_id }}" data-toggle="modal" data-target="#modal-lg-coach">{{ $agent->tl }}</span>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                              <th>ID</th>
                              <th>Date</th>
                              <th>Progress</th>
                              <th>Title</th>
                              <th>Details</th>
                              <th>Information</th>
                              <th>Status</th>
                            </tr>
                            </tfoot>
                          </table>
                        @else
                        <table id="example3" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Progress</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Information</th>
                            <th>Status</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($agent_list as $agent)
                            <tr>
                              <td>
                                @php
                                  $strlen = strlen($agent->id);
                                  switch ($strlen) {
                                    case 1:
                                      echo "CL-00000".$agent->id;
                                      break;
                                    case 2:
                                      echo "CL-0000".$agent->id;
                                      break;
                                    case 3:
                                      echo "CL-000".$agent->id;
                                      break;
                                    case 4:
                                      echo "CL-00".$agent->id;
                                      break;
                                    case 5:
                                      echo "CL-0".$agent->id;
                                      break;
                                    default:
                                      echo $agent->id;
                                      break;
                                  }
                                @endphp
                              </td>
                              <td>{{ date('m/d/Y', strtotime($agent->coaching_date)) }}</td>
                              <td>
                                @php
                                  
                                  $date = date('m/d/Y', strtotime($agent->coaching_date));
                                  $end = strtotime(date("m/d/Y", strtotime($date)) . "+1 month");
                                  $now = date ("m/d/Y");

                                  $datetime1 = date_create(date('Y-m-d', $end));
                                  $datetime2 = date_create(date ('Y-m-d'));
                                    
                                  $interval = date_diff($datetime2, $datetime1);
                                  $progress = $interval->format('%R%a');
                                  // echo $progress;
                                  if ($progress < 30 && $progress > 0) {
                                    $timeprog = (30 - $progress) / 30 * 100;

                                    if ($timeprog <= 30) {
                                      echo "<div class='progress progress-xs'>
                                              <div class='progress-bar bg-danger' style='width:".$timeprog."%'></div>
                                            </div>";
                                    }elseif ($timeprog > 30 && $progress <= 80) {
                                      echo "<div class='progress progress-xs'>
                                              <div class='progress-bar bg-warning' style='width:".$timeprog."%'></div>
                                            </div>";
                                    }else{
                                      echo "<div class='progress progress-xs'>
                                              <div class='progress-bar bg-success' style='width:".$timeprog."%'></div>
                                            </div>";
                                    }
                                  }elseif ($progress <= 0) {
                                    echo "<a href=''>Result</a>";
                                  } else{
                                    echo "<div class='progress progress-xs'>
                                            <div class='progress-bar bg-danger' style='width:0%'></div>
                                          </div>";
                                  }

                                  // $progress =  round($end->diff($now)->format("%d"));

                                  
                                  
                                @endphp
                              </td>
                              <td>{{ $agent->title }}</td>
                              <td>
                                @if(strlen("$agent->description") > 20)
                                  {{ substr($agent->description, 0, 90) . "..." }}
                                @else
                                  {{ $agent->description }}
                                @endif
                              </td>
                              <td><a href="javascript:void(0)" target-id="{{ $agent->agent_id }}" session-id="{{ $agent->id }}" class="show-sp-session" data-toggle="modal" data-target="#modalGoal">Open</a></td>
                              <td>
                                @if($agent->status == "")
                                  <button class="form-control btn-accept btn-success" target-id="{{ $agent->id }}">
                                    <i class="nav-icon fas fa-thumbs-up"></i>
                                  </button>
                                  <button class="form-control btn-reject btn-danger" target-id="{{ $agent->id }}">
                                    <i class="nav-icon fas fa-thumbs-down"></i>
                                  </button>
                                @else
                                 <center>{{ $agent->status }}</center>
                                  {{-- <button class="form-control btn-reason btn-danger" target-id="{{ $agent->id }}">
                                    <i class="nav-icon fas fa-pencil-alt"></i>
                                  </button> --}}
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                          <tfoot>
                          <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Progress</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Information</th>
                            <th>Status</th>
                          </tr>
                          </tfoot>
                        </table>
                        @endif
                      </div>
                      <!-- /.card-body -->
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<script src="{{ asset('js/coaching.js') }}" defer></script>
