<div class="row">
    <!-- Profile Image -->
    <div class="col-4 card">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="../../dist/img/user8-128x128.jpg"
               alt="User profile picture">
        </div>

        <h3 class="profile-username text-center active-user">{{ Auth::user()->name }}</h3>

        <p class="text-muted text-center user-position">Call Centre Agent</p>
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Shift Manager:</b> <a class="float-right my-sm">Ezra Tillman</a>
          </li>
          <li class="list-group-item">
            <b>Team Lead:</b> <a class="float-right my-tl">Ezra Tillman</a>
          </li>
          <li class="list-group-item">
            <b>Group:</b> <a class="float-right group-name">Ezra Tillman</a>
          </li>
        </ul>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- About Me -->
    <div class="col-4 card ">
      <div class="card-header">
        <h3 class="card-title">About Me</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Call Sign</strong>

        <p class="text-muted call-sign">
          Billy Joe
        </p>

        <hr>

        <strong><i class="fas fa-map-marker-alt mr-1"></i> Line of Support</strong>

        <p class="text-muted">Socmed</p>

        <hr>

        <strong><i class="fas fa-pencil-alt mr-1"></i> Tenure Bracket</strong>

        <p class="text-muted my-tenure">
          >1year <2years
        </p>

        <hr>

        <strong><i class="far fa-file-alt mr-1"></i>Location</strong>

        <p class="text-muted group-location">UAS Pasig</p>
      </div>
      <!-- /.card-body -->
    </div>
    <div class="col-4 card ">
        <div class="card-header">
          <h3 class="card-title">Security</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i>Displayed Name</strong>
  
          <p class="text-muted">
            <input type="text" class="form-control active-name">
          </p>
  
          <hr>
  
          <strong><i class="fas fa-map-marker-alt mr-1"></i>New Password</strong>
  
          <p class="text-muted"><input type="password" class="form-control new-password"></p>
  
        </div>
        <!-- /.card-body -->
      </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "profile",
            success: function (response) {
                console.log(response);
                $('.my-tl').html('').html(response.tl);
                $('.my-sm').html('').html(response.sm);
                $('.call-sign').html('').html(response.data[0]['call_sign']);
                $('.active-name').val(response.data[0]['name']);
                $('.active-user').html('').html(response.data[0]['name']);
                $('.user-position').html('').html(response.position);
                $('.group-name').html('').html(response.data[0]['subgroup_name']);
                $('.group-location').html('').html(response.data[0]['group_name']);
                $('.my-tenure').html('').html(response.tenure + " Months");
                $('.user-position').html('').html(response.data[0]['position_name']);
            }
        });
    });
</script>