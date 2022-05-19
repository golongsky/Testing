<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="refresh" content="900;url=login" /> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
 
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <!-- Calendar -->
    <link  rel="stylesheet" href="plugins/fullcalendar/main.css"></link>
    <link rel="stylesheet" href="plugins/fullcalendar/main.min.css"></link>

    <style>
      .modal-backdrop {
        width: 200vw !important;
        height: 200vh !important;
      }
    .user-form-loader{
      width: 100%;
      height: 100%;
      background-color: #ffffff;
      position: absolute;
      z-index: 9;
      display: none;
    }
    .user-loader{
      height: 100px;
      width: 100px;
      position: absolute;
      top: 40%;
      left: 45%;
    }
    </style>
    <script type="text/javascript">
      function zoom() {
          document.body.style.zoom = "80%" 
      }
    </script>
</head>
 
<body class="layout-navbar-fixed" onload="zoom()">
    <div id="app">
        <input type="hidden" class="cur-user-id" value="{{ Auth::user()->id }}">
        <input type="text" class="cur-page" style="display: none">
        @include('includes.preloader')
        @include('includes.tableloader')

        @include('includes.header')

        @include('includes.menu')

        <main class="main-layout">
          {{-- @include('pages.dashboard') --}}
          @yield('content')
        </main>

        @include('modals.coachingmod')
        @include('modals.coachinggoal')
        @include('modals.coachform')
        @include('modals.uploading')
        @include('modals.emailcontroller')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
    </div>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- jQuery UI -->
<script src="plugins/jquery-ui/jquery-ui.js"></script>



{{-- <!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script> --}}



<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- FLOT CHARTS -->
<script src="plugins/flot/jquery.flot.js"></script>
<script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
<script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Scripts -->
<script src="{{ asset('js/main.js') }}" defer></script>

{{-- Custom JS --}}
<script src="{{ asset('js/functions.js') }}" defer></script>





</body>
</html>
