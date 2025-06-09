@extends('layout.main')
@section('title', 'Kirim Whatsapp Permohonan')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Izin Belajar</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Kirim Pesan Whatsapp Permohonan Izin Belajar</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/prosesizbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Kirim Whatsapp Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Kirim Whatsapp permohonan izin belajar</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Sending Whatsapp...
            </button>
          </div><!-- card-body -->
            <input type="hidden" name="id" id="id" value="{{$izbel->id}}">
        </div><!-- card -->
      </div>
        <!-- Button trigger modal -->
    </div><!-- container -->
  </div>
</div><!-- content -->  


  
  

<script>
    $(document).ready(function() {

        var id = $('#id').val();
        // 'http://localhost:8000/izbel/'+id+'/kirimwaizbel'
        var url = '/izbel/'+id+'/kirimwaizbel';
        var url2 = '/izbel';
        $.ajax({
            url	     : url,
            type     : 'get',
            dataType : 'html',
            data     : id,
            success  : function(respons){
                // $('#pesan_kirim').html(respons);
                console.log( "berhasil" );
                window.location=url2;
            },
        });
    });
</script>
@endsection