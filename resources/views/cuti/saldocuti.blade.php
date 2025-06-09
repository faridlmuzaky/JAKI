@extends('layout.main')
@section('title', 'Saldo Cuti')

@section('content')
<div class="content-body ">
     {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Saldo Usul Cuti</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Saldo Cuti</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          {{-- <a href="{{url('/approvalcutiatasan')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a> --}}
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-6 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Saldo Cuti {{ Auth::user()->name}}</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Saldo Cuti</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            

        <div class="row">
            
            
            <div class="col-md- col-lg-10 order-md-last">
                

                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Informasi Cuti</span>
                        {{-- <span class="badge badge-success">{{$izbel->nip}}</span> --}}
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Jenis Cuti</h6>
                            <medium class="text-muted"></medium>
                        </div>

                            <span class="my-0"><h6 class="my-0">Sisa Cuti</h6></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-2</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t2}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-1</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t1}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-0</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t0}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Sakit</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cs}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Alasan Penting</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cap}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Besar</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cbesar}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Diluar Tanggungan Negara</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cltn}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Melahirkan</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cm}}
                            </span>
                        </li>
                        
                       
                        
                       
                    </ul>
                   
                
            </div>

            

            
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