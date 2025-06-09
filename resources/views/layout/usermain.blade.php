
<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DashForge">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="http://themepixels.me/dashforge/img/dashforge-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/dashforge">
    <meta property="og:title" content="DashForge">
    <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

    <meta property="og:image" content="http://themepixels.me/dashforge/img/dashforge-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/dashforge/img/dashforge-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <title>JAKI - @yield('title')</title>

    <!-- vendor css -->
    <link href="{{ asset('style/dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet')}}">
    <link href="{{ asset('style/dashforge')}}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('style/dashforge')}}/assets/css/dashforge.css">
    <link rel="stylesheet" href="{{ asset('style/dashforge')}}/assets/css/dashforge.dashboard.css">
  </head>
  <body>

    <aside class="aside aside-fixed">
      <div class="aside-header">
        <a href="/dashboard" class="aside-logo">Kinerja<span>Kita</span></a>
        <a href="" class="aside-menu-link">
          <i data-feather="menu"></i>
          <i data-feather="x"></i>
        </a>
      </div>
      <div class="aside-body">
        <div class="aside-loggedin">
          <div class="d-flex align-items-center justify-content-start">
            <a href="" class="avatar"><img src="{{asset('images').'/'.Auth::User()->profile_photo_path}}" class="rounded-circle" alt=""></a>
            <div class="aside-alert-link">
              <a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
              <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>
              <a href="" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
            </div>
          </div>
          <div class="aside-loggedin-user">
            <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
              <h6 class="tx-semibold mg-b-0">{{Auth::User()->name}}</h6>
              <i data-feather="chevron-down"></i>
            </a>
            <p class="tx-color-03 tx-12 mg-b-0">Administrator</p>
          </div>
          <div class="collapse" id="loggedinMenu">
            <ul class="nav nav-aside mg-b-0">
              <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
              <li class="nav-item"><a href="" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>
              <li class="nav-item"><a href="" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
              <li class="nav-item"><a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Help Center</span></a></li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <li class="nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                  this.closest('form').submit();" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>
              </form>
            </ul>
          </div>
        </div><!-- aside-loggedin -->
        <ul class="nav nav-aside">
          <li class="nav-label">Dashboard</li>
          <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="/dashboard" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>
          {{-- <li class="nav-item"><a href="dashboard-two.html" class="nav-link"><i data-feather="globe"></i> <span>Website Analytics</span></a></li> --}}
          <li class="nav-item {{ (request()->is(['izbel','addizbel','izbel/*'])) ? 'active' : '' }}"><a href="/izbel" class="nav-link"><i data-feather="book-open"></i> <span>Izin Belajar</span></a></li>
          <li class="nav-item "><a href="dashboard-four.html" class="nav-link"><i data-feather="pocket"></i> <span>Pencantuman Gelar</span></a></li>
          <li class="nav-item "><a href="dashboard-four.html" class="nav-link"><i data-feather="credit-card"></i> <span>Kartu Suami/Istri</span></a></li>
          <li class="nav-item "><a href="dashboard-four.html" class="nav-link"><i data-feather="command"></i> <span>Cuti KPA</span></a></li>
          {{-- <li class="nav-item"><a href="dashboard-three.html" class="nav-link"><i data-feather="pie-chart"></i> <span>Cryptocurrency</span></a></li> --}}
          {{-- <li class="nav-label mg-t-25">Web Apps</li>
          <li class="nav-item"><a href="app-calendar.html" class="nav-link"><i data-feather="calendar"></i> <span>Calendar</span></a></li>
          <li class="nav-item"><a href="app-chat.html" class="nav-link"><i data-feather="message-square"></i> <span>Chat</span></a></li>
          <li class="nav-item"><a href="app-contacts.html" class="nav-link"><i data-feather="users"></i> <span>Contacts</span></a></li>
          <li class="nav-item"><a href="app-file-manager.html" class="nav-link"><i data-feather="file-text"></i> <span>File Manager</span></a></li>
          <li class="nav-item"><a href="app-mail.html" class="nav-link"><i data-feather="mail"></i> <span>Mail</span></a></li> --}}

          {{-- <li class="nav-label mg-t-25">Pages</li>
          <li class="nav-item with-sub {{ (request()->is(['user','adduser'])) ? 'active show' : '' }}">
            <a href="" class="nav-link open"><i data-feather="user"></i> <span>User Pages</span></a>
            <ul>
              <li><a href="page-profile-view.html">View Profile</a></li>
              <li class="{{ (request()->is(['user','adduser'])) ? 'active' : '' }}"><a href="{{ url('/user')}}">User Management</a></li> --}}
              {{-- <li><a href="page-groups.html">Groups</a></li>
              <li><a href="page-events.html">Events</a></li> --}}
            {{-- </ul>
          </li> --}}
          {{-- <li class="nav-item with-sub">
            <a href="" class="nav-link"><i data-feather="file"></i> <span>Other Pages</span></a>
            <ul>
              <li><a href="page-timeline.html">Timeline</a></li>
            </ul>
          </li> --}}
          {{-- <li class="nav-label mg-t-25">User Interface</li>
          <li class="nav-item"><a href="../../components" class="nav-link"><i data-feather="layers"></i> <span>Components</span></a></li>
          <li class="nav-item"><a href="../../collections" class="nav-link"><i data-feather="box"></i> <span>Collections</span></a></li> --}}
        </ul>
      </div>
    </aside>

    <div class="content ht-100v pd-0">
      <div class="content-header">
        <div class="content-search">
          <i data-feather="search"></i>
          <input type="search" class="form-control" placeholder="Search...">
        </div>
        <nav class="nav">
          <a href="" class="nav-link"><i data-feather="help-circle"></i></a>
          <a href="" class="nav-link"><i data-feather="grid"></i></a>
          <a href="" class="nav-link"><i data-feather="align-left"></i></a>
        </nav>
      </div><!-- content-header -->

     

    <script src="{{ asset('style/dashforge')}}/lib/jquery/jquery.min.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/feather-icons/feather.min.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/jquery.flot/jquery.flot.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/jquery.flot/jquery.flot.stack.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/flot.curvedlines/curvedLines.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/peity/jquery.peity.min.js"></script>
    <script src="{{ asset('style/dashforge')}}/lib/chart.js/Chart.bundle.min.js"></script>

    <script src="{{ asset('style/dashforge')}}/assets/js/dashforge.js"></script>
    <script src="{{ asset('style/dashforge')}}/assets/js/dashforge.aside.js"></script>
    <script src="{{ asset('style/dashforge')}}/assets/js/dashforge.sampledata.js"></script>
    <script src="{{ asset('style/dashforge')}}/assets/js/dashboard-four.js"></script>

    <!-- append theme customizer -->
    <script src="{{ asset('style/dashforge')}}/lib/js-cookie/js.cookie.js"></script>
    <script src="{{ asset('style/dashforge')}}/assets/js/dashforge.settings.js"></script>

    @yield('content')
  </body>
</html>
