<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ClarkBook</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <input type="text" class="active-access-id" style="display: none" value="{{ Auth::user()->access_level }}">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-lg-bio" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ url('/home') }}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item" style="display: none">
            @if(Auth::user()->access_level == 2)
            <a href="javascript:void(0)" target="myqms" class="nav-link nav-red">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                My QA Result
              </p>
            </a>
            @else
            <a href="javascript:void(0)" target="qms" class="nav-link nav-red">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                QMS
              </p>
            </a>
            
            @endif
          </li>
          <li class="nav-item"  style="display: none">
            <a href="javascript:void(0)" target="ctl" class="nav-link nav-red">
              <i class="nav-icon fas fa-people-arrows"></i>
              <p>
                @if (Auth::user()->access_level == 2)
                  My Coachings
                @else
                Coaching Tool
                @endif
              </p>
            </a>
          </li>
          @if (Auth::user()->access_level != 2)
            <li class="nav-item" style="display: none">
              {{-- <a href="{{ url('/action-logs') }}" class="nav-link"> --}}
                <a href="javascript:void(0)" target="action-logs" class="nav-link nav-red">
                <i class="nav-icon fas fa-running"></i>
                <p>
                  Action Items
                </p>
              </a>
            </li>
          @else
            <li class="nav-item" style="display: none">
              <a href="javascript:void(0)" target="atm" class="nav-link nav-red">
                <i class="nav-icon fas fa-running"></i>
                <p>
                  My Action Items
                </p>
              </a>
            </li>
          @endif
          <li class="nav-item">
            <a href="javascript:void(0)" target="etr" class="nav-link nav-red">
              <i class="nav-icon fas fa-th"></i>
              <p>
                ETR
              </p>
            </a>
          </li>
          <li class="nav-item" style="display: none">
            <a href="javascript:void(0)" target="calendar" class="nav-link nav-red">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Calendar
              </p>
            </a>
          </li>
          @if (Auth::user()->access_level == 1 or Auth::user()->access_level == 5)
            <li class="nav-item">
              <a href="javascript:void(0)" target="umgt" class="nav-link nav-red">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>
                  User Management
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0)" target="report" class="nav-link nav-red">
                <i class="nav-icon fas fa-receipt"></i>
                <p>
                  Reporting
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0)" target="analytics" class="nav-link nav-red">
                <i class="nav-icon fas fa-server"></i>
                <p>
                  Analytics
                </p>
              </a>
            </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();" class="nav-link">
                <i class="nav-icon fas fa-door-open"></i>
                <p>
                  Log Out
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  @include('modals.profile')