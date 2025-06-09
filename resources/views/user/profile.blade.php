@extends('layout.main')
@section('title', 'User Management')

@section('content')
<div class="content-body">
    {{--<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1"> User Profile</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/user')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">User Profile</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Informasi Pengguna</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">

            <div class="row">
                <div class="col-sm-3 ">
                  <div class="avatar avatar-xxl avatar-online"><img src="{{asset('images').'/'.$userku->profile_photo_path}}" class="rounded-circle" alt=""></div>
                </div><!-- col -->
                <div class="col-sm-5 mg-t-20 mg-sm-t-0 mg-lg-t-10">
                  <h5 class="mg-b-2 tx-spacing--1">{{$userku->name}}</h5>
                  <p class="tx-color-03 mg-b-25">{{$userku->username}} <br>{{$userku->jabatan}}</p>
                  {{-- <p class="tx-color-03 mg-b-25">{{$userku->jabatan}}</p> --}}
                  {{-- <p class="tx-color-03 mg-b-25">{{$userku->satua}}</p> --}}
                  <div class="d-flex mg-b-25">
                    <a href="/user/{{$userku->id}}/edit" class="btn btn-xs btn-white flex-fill">Edit</a>
                    {{-- <a href="" class="btn btn-xs btn-primary flex-fill mg-l-10">Delete</a> --}}
                  </div>

                  {{-- <p class="tx-13 tx-color-02 mg-b-25">Redhead, Innovator, Saviour of Mankind, Hopeless Romantic, Attractive 20-something Yogurt Enthusiast... <a href="">Read more</a></p> --}}

                  <div class="col-sm-6 col-md-5 col-lg mg-t-40">
                    <label class="tx-sans tx-10 tx-semibold tx-uppercase tx-color-01 tx-spacing-1 mg-b-15">Contact Information</label>
                    <ul class="list-unstyled profile-info-list">
                      <li><i data-feather="user"></i> <span class="tx-color-03">{{$userku->name}}</span></li>
                      <li><i data-feather="smile"></i> <span class="tx-color-03">{{$userku->username}}</span></li>
                      {{-- <li><i data-feather="smartphone"></i> <a href="">(+1) 012 345 6789</a></li>
                      <li><i data-feather="phone"></i> <a href="">(+1) 987 654 3201</a></li> --}}
                      <li><i data-feather="message-circle"></i> <a href="">{{$userku->telp}}</a></li>
                    </ul>
                  </div><!-- col -->
                </div><!-- col -->
                
            </div>
            
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
</div><!-- content -->  

<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>
@endsection