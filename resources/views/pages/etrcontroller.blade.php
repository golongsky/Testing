<div class="content-wrapper" style="min-height: 480px !important">
    <section class="content" style="margin-top: 5px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                        <div id="stopwatch">
                            <!-- CURRENT TIME -->
                            <div id="sw-time">00:00:00</div>
                      
                            <!-- CONTROLS -->
                            <input type="button" value="Reset" id="sw-rst" disabled style="display: none"/>
                            <input type="button" value="Start" id="sw-go" disabled style="width: 100%"/>
                            <select class="form-control trans-tp" style="margin-top: 5px"></select>
                            <textarea class="form-control" id="commentSection" rows="6" style="margin-top: 5px"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>

<style>

    #stopwatch {
      display: flex;
      flex-wrap: wrap;
      max-width: 320px;
      margin: 0 auto;
    }

    /* (B) TIME */
    #sw-time {
      width: 100%;
      padding: 20px 0;
      font-size: 48px;
      font-weight: bold;
      text-align: center;
      background: #000;
      color: #fff;
    }

    /* (C) BUTTONS */
    #sw-rst, #sw-go {
      box-sizing: border-box;
      width: 50%;
      cursor: pointer;
      padding: 20px 0;
      border: 0;
      color: #fff;
      font-size: 20px;
    }
    #sw-rst { background-color: #a32208; }
    #sw-go { background-color: #20a308; }

  </style>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<script src="plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="{{ asset('js/tracker.js') }}" defer></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
