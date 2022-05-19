<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Daily Production / Non Production Report</h5>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          @foreach($prod->chunk(4) as $chunk)
            <div class="row">
              @foreach ($chunk as $value)
                <div class="col-md-3">
                  <div class="progress-group">
                    {{ $value->transaction_name }}
                    <span class="float-right"><b>{{ $value->user_count }}</b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: {{ $value->user_count }}%"></div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
          <div  style="height: 50px"></div>
          @foreach($nonprod->chunk(4) as $chunk)
            <div class="row">
              @foreach ($chunk as $value)
                <div class="col-md-3">
                  <div class="progress-group">
                    {{ $value->transaction_name }}
                    <span class="float-right"><b>{{ $value->user_count }}</b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: {{ $value->user_count }}%"></div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>