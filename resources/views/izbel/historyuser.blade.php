@extends('layout.main')
@section('title', 'Kunci Permohonan')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">History Izin Belajar</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">History Permohonan Izin Belajar</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/izbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">History Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">History permohonan izin belajar</p>
          </div><!-- card-header -->
            <div class="card-body pd-20">
            
                    <ul class="steps steps-vertical">
                    @foreach ($audit as $isi)
                    <li class="step-item complete">
                        <a href="" class="step-link">
                        <span class="step-number">{{$loop->iteration}}</span>
                        <span class="step-title">{{$isi->description}}</span>
                        </a>
                        <ul>
                        <li class="active"><a href="">{{ date('d-m-Y H:i', strtotime($isi->created_at))}}</a></li>
                        <li class="active"><a href="">User : {{$isi->name}}</a></li>
                        {{-- <li class="disabled"><a href="">Educational Background</a></li>  --}}
                        </ul>
                    </li>
                    

                    {{-- <ul class="steps steps-vertical">
                        <li class="step-item complete">
                        <a href="" class="step-link">
                            <span class="step-number">1</span>
                            <span class="step-title">Personal Information</span>
                        </a>
                        <ul>
                            <li class="complete"><a href="">Contact Details</a></li>
                            <li class="complete"><a href="">Job Experience</a></li>
                            <li class="complete"><a href="">Educational Background</a></li>
                        </ul>
                        </li>
                        <li class="step-item active">
                        <a href="" class="step-link">
                            <span class="step-number">2</span>
                            <span class="step-title">Account Information</span>
                        </a>
                        <ul>
                            <li class="complete"><a href="">Favorites</a></li>
                            <li class="active"><a href="">Collections</a></li>
                            <li class="disabled"><a href="">Products</a></li>
                        </ul>
                        </li>
                        <li class="step-item disabled">
                        <a href="" class="step-link">
                            <span class="step-number">3</span>
                            <span class="step-title">Payment Information</span>
                        </a>
                        <ul>
                            <li><a href="">Purchases</a></li>
                            <li><a href="">Order History</a></li>
                        </ul>
                        </li>
                    </ul> --}}

                    @endforeach
                    </ul>
            
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
        <!-- Button trigger modal -->
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