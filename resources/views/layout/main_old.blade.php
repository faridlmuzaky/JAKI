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
   
    <link href="{{ asset('style/dashforge')}}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('style/dashforge')}}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('style/dashforge')}}/assets/css/dashforge.css">
    <link rel="stylesheet" href="{{ asset('style/dashforge')}}/assets/css/dashforge.dashboard.css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css"> --}}
  </head>
  <body>

   <?php
          
              // $jumlah = DB::table('master_cutis_detail')
              //         ->select('status',DB::raw('count(*) as total'))
              //         ->groupBy('status')
              //         ->get();
              // dd($jumlah);  

              $usulanbaru = DB::table('master_cutis_detail')
                      ->where('status','Usulan Baru')
                      ->count();     

              $atasan = DB::table('master_cutis_detail')
                      ->where('status','Persetujuan Atasan','and')
                      ->where('atasan_langsung',Auth::user()->username)
                      ->count();

              $ketua = DB::table('master_cutis_detail')
                      ->where('status','Persetujuan Ketua','and')
                      ->where('pejabat_berwenang',Auth::user()->username)
                      ->count();        
              // $disetujui=$jumlah[0]->total;
              // $ditangguhkan=$jumlah[1]->total;
              // $atasan=$jumlah[2]->total;
              // $ketua=$jumlah[3]->total;
              // $tidakdisetujui=$jumlah[4]->total;
              // $usulanbaru=$jumlah[5]->total;
                  // echo $jumlah;
            
        

   ?>
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
              {{-- <a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
              <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>
              <a href="" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a> --}}
              
                        
            </div>
          </div>
          <div class="aside-loggedin-user">
            <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
              <h6 class="tx-semibold mg-b-0">{{Auth::User()->name}}</h6>
              <i data-feather="chevron-down"></i>
            </a>
            <p class="tx-color-03 tx-12 mg-b-0">@if (Auth::User()->role==1)Administrator
                @elseif (Auth::User()->role==0) Admin Satker @elseif (Auth::User()->role==2) Pegawai @endif</p>
          </div>
          <div class="collapse" id="loggedinMenu">
            <ul class="nav nav-aside mg-b-0">
              {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li> --}}
              {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li> --}}
              {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li> --}}
              {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Help Center</span></a></li> --}}
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
          @if (Auth::User()->role ==1)
            <li class="nav-item {{ (request()->is(['prosesizbel','addizbel','izbel/*'])) ? 'active' : '' }}"><a href="/prosesizbel" class="nav-link"><i data-feather="book-open"></i> <span>Proses Izin Belajar</span></a></li>
            {{-- <li class="nav-item "><a href="dashboard-four.html" class="nav-link"><i data-feather="pocket"></i> <span>Proses Pencantuman Gelar</span></a></li> --}}
            {{-- <li class="nav-item "><a href="dashboard-four.html" class="nav-link"><i data-feather="credit-card"></i> <span>Proses Kartu Suami/Istri</span></a></li> --}}
            {{-- <li class="nav-item {{ (request()->is(['cuti'])) ? 'active' : '' }}"><a href="{{ url('/cuti')}}" class="nav-link"><i data-feather="command"></i> <span>Proses Cuti KPA</span></a></li> --}}
          @elseif (Auth::User()->role ==0)
            {{-- <li class="nav-item {{ (request()->is(['izbel','addizbel','izbel/*'])) ? 'active' : '' }}"><a href="/izbel" class="nav-link"><i data-feather="book-open"></i> <span>Izin Belajar</span></a></li>
            <li class="nav-item "><a href="{{ url('/gelar')}}" class="nav-link"><i data-feather="pocket"></i> <span>Pencantuman Gelar</span></a></li>

            <li class="nav-item "><a href="{{ url('/kartu')}}" class="nav-link"><i data-feather="credit-card"></i> <span>Kartu Suami/Istri</span></a></li>

            <li class="nav-item {{ (request()->is(['cuti'])) ? 'active' : '' }}"><a href="{{ url('/cuti')}}" class="nav-link"><i data-feather="command"></i> <span>Cuti KPA</span></a></li> --}}

        {{-- <span class="badge badge-pill badge-warning" style="float:right;margin-bottom:-15px;margin-right:-18px;font-size:10px">123</span>
<a class="nav-link" href="/News/">News <span class="sr-only">(current)</span></a> --}}
          @endif
          <li class="nav-item {{ (request()->is(['cutiuser'])) ? 'active' : '' }} "><a href="{{ url('/cutiuser')}}" class="nav-link"><i data-feather="calendar"></i> <span>Usul Cuti</span></a></li>
          
          @if (Auth::User()->role==1)
          <li class="nav-item {{ (request()->is(['approvalcuti','approvalcutikepeg/*'])) ? 'active' : '' }}  ">
            
            
            <a href="{{ url('/approvalcuti')}}" class="nav-link flex-end"><i data-feather="check-circle"></i>Validasi Cuti &ensp; @if ($usulanbaru>0)<sup><small><span class="badge badge-danger flex-end">{{$usulanbaru}}</span></small></sup>@endif</a>
          </li>

          @endif
         
          
          <li class="nav-item with-sub {{ (request()->is(['approvalcutiatasan','approvalcutippk','approvalcutippkdetail/*','approvalcutiatasandetail/*'])) ? 'active show' : '' }}">
              <a href="" class="nav-link open"><i data-feather="user"></i> Approval Cuti &ensp; @if (($total=$atasan+$ketua)>0)<sup><small><span class="badge badge-danger flex-end">{{$total=$atasan+$ketua}}</span></small></sup>@endif</a>
              <ul>
                {{-- <li><a href="page-profile-view.html">Persetujuan Atasan</a></li> --}}
                <li class="nav-item {{ (request()->is(['approvalcutiatasan','approvalcutiatasan/*'])) ? 'active' : '' }}"><a href="{{ url('/approvalcutiatasan')}}" ><i data-feather="check-circle"></i> <span>Atasan Langsung</span>&ensp; @if ($atasan>0)<sup><small><span class="badge badge-danger flex-end">{{$atasan}}</span></small></sup></a>@endif</li>
                <li class="nav-item {{ (request()->is(['approvalcutippk','approvalcutippkdetail/*'])) ? 'active' : '' }}"><a href="{{ url('/approvalcutippk')}}"><i data-feather="user-check"></i> <span>Ketua/PPK</span>&ensp; @if ($ketua>0) <sup><small><span class="badge badge-danger flex-end">{{$ketua}}</span></small></sup>@endif</a></li>
              </ul>
          </li>
          <li class="nav-item {{ (request()->is(['absen'])) ? 'active' : '' }}"><a href="{{ url('/absen')}}" class="nav-link"><i data-feather="clock"></i> <span>Isi Absensi</span></a></li>
          {{-- <li class="nav-item {{ (request()->is(['absen'])) ? 'active' : '' }}"><a href="{{ url('/absen')}}" class="nav-link"><i data-feather="file-text"></i> <span>Laporan Presensi</span></a></li> --}}

          @if (Auth::User()->role==1)
          <li class="nav-item with-sub {{ (request()->is(['approvalcutiatasan','approvalcutippk','approvalcutippkdetail/*','approvalcutiatasandetail/*'])) ? 'active show' : '' }}">
            <a href="" class="nav-link open"><i data-feather="user"></i> Surat Tugas &ensp; @if (($total=$atasan+$ketua)>0)<sup><small><span class="badge badge-danger flex-end">{{$total=$atasan+$ketua}}</span></small></sup>@endif</a>
            <ul>
              {{-- <li><a href="page-profile-view.html">Persetujuan Atasan</a></li> --}}
              <li class="nav-item {{ (request()->is(['approvalcutiatasan','approvalcutiatasan/*'])) ? 'active' : '' }}"><a href="{{ url('/surattugas')}}" ><i data-feather="check-circle"></i> <span>Surat Tugas</span>&ensp; @if ($atasan>0)<sup><small><span class="badge badge-danger flex-end">{{$atasan}}</span></small></sup></a>@endif</li>
              <li class="nav-item {{ (request()->is(['approvalcutippk','approvalcutippkdetail/*'])) ? 'active' : '' }}"><a href="{{ url('/spd')}}"><i data-feather="user-check"></i> <span>SPD</span>&ensp; @if ($ketua>0) <sup><small><span class="badge badge-danger flex-end">{{$ketua}}</span></small></sup>@endif</a></li>
            </ul>
          </li>
          @endif
          
          


          <li class="nav-label mg-t-25">Control Panel</li>
          
          <li class="nav-item with-sub {{ (request()->is(['user/*','adduser','user'])) ? 'active show' : '' }}">
            <a href="" class="nav-link open"><i data-feather="user"></i> <span>User Pages</span></a>
            <ul>
              <li class="{{ (request()->is(['user/*','adduser'])) ? 'active' : '' }}"><a href="/user/{{Auth::user()->id}}/profileuser"><i data-feather="award"></i>View Profile</a></li>
              @if (Auth::User()->role ==1)
              <li class="{{ (request()->is(['user','adduser'])) ? 'active' : '' }}"><a href="{{ url('/user')}}"><i data-feather="user-plus"></i>Pengaturan User</a></li>
              @endif
              {{-- <li><a href="page-groups.html">Groups</a></li>
              <li><a href="page-events.html">Events</a></li> --}}
            </ul>
          </li>      
          @if (Auth::User()->role ==1 or Auth::User()->role ==0) 
            <li class="nav-item with-sub {{ (request()->is(['laporanabsen'])) ? 'active show' : '' }}">
              <a href="" class="nav-link open"><i data-feather="archive"></i> <span>Laporan Absensi</span></a>
              <ul>
                <li class="{{ (request()->is(['laporanabsen'])) ? 'active' : '' }}"><a href="{{url('/laporanabsen')}}">Lihat Data Absen</a></li>
                {{-- <li class="{{ (request()->is(['user','adduser'])) ? 'active' : '' }}"><a href="{{ url('/user')}}">User Management</a></li> --}}
                {{-- <li><a href="page-groups.html">Groups</a></li>
                <li><a href="page-events.html">Events</a></li> --}}
              </ul>
            </li>    
          @endif  
          
          <li class="nav-item with-sub {{ (request()->is(['mastercuti','addmastercuti','saldocuti'])) ? 'active show' : '' }}">
            <a href="" class="nav-link open"><i data-feather="database"></i> <span>Data Cuti</span></a>
            <ul>
              <li class="{{(request()->is(['saldocuti'])) ? 'active' : ''}}"><a href="{{ url('/saldocuti')}}"><i data-feather="file-text"></i>Saldo Cuti</a></li>
              {{-- @if (Auth::User()->role ==3)
              <li class="{{(request()->is(['mastercuti','mastercutikpa'])) ? 'active' : ''}}"><a href="{{ url('/mastercuti')}}">Saldo Awal Cuti Tahunan</a></li>
              @endif --}}
              @if (Auth::User()->role ==1)
              <li class="{{ (request()->is(['mastercuti','mastercutikpa'])) ? 'active' : '' }}"><a href="{{ url('/mastercuti')}}"><i data-feather="list"></i>Atur Saldo Cuti</a></li>
              @endif
              {{-- <li><a href="page-groups.html">Groups</a></li>
              <li><a href="page-events.html">Events</a></li> --}}
            </ul>
          </li> 
          
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
        {{-- <nav class="nav"> --}}
          
         

          
          {{-- <a href="" class="nav-link"><i data-feather="help-circle"></i></a> --}}
          
          {{-- <a href="" class="dropdown"><i data-feather="grid"></i></a>
          <a href="" class="nav-link"><i data-feather="align-left"></i></a> --}}
          
        {{-- </nav> --}}
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
    {{-- datatable --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    
    
    








    <!-- append theme customizer -->
    <script src="{{ asset('style/dashforge')}}/lib/js-cookie/js.cookie.js"></script>
    <script src="{{ asset('style/dashforge')}}/assets/js/dashforge.settings.js"></script>


    {{-- <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script> --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGPibiPg60-mBMzV12-Lt1VIMVGvjf1Kg=initialize" async defer></script> --}}

    @yield('content')

  </body>
</html>
