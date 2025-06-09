@extends('layout.main')
@section('title', 'Daftar Rapat')

@section('content')

<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Isi Notula Rapat</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Isi Notula Rapat</h4>
        </div>
        <div class="d-none d-md-block">
            {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
            <button class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5" onclick="history.back()"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Kembali</button>
            
          </div>
      </div>
      
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
            @endif
            @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
            @endif
            <h6 class="mg-b-5">Pengisian Notula Rapat</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Silahkan mengisi notula kegiatan.</p>
     
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <form method="POST" action="{{ url('/savenotula') }}" class="needs-validation" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-lg-12">
                    
                        @foreach ($data as $item)
                        <input type="hidden" value="{{$item->id_rapat}}" name="id_rapat">
                        <textarea id="summernote" name="notula" autofocus value="{{$item->notulensi}}">{{$item->notulensi}}</textarea>
                        @endforeach

                </div><!-- col -->
            </div><!-- row -->
              <div class="row mt-3">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success"><i data-feather="save" class="wd-20 mg-r-5"></i>Simpan</button>
                </div>
              </div>
            </form>
            </div>
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
</div><!-- content -->  

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> --}}


    <script>     
 
      $('#tabel').dataTable( {
        // responsive:true
        "drawCallback": function( settings ) {
            feather.replace();
        
    },
      responsive: true,
        language: {
          searchPlaceholder: 'Cari...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
  });
    </script>

    <script>
        $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Isi notulensi disini',
            height: 300
        });
        });
    </script>
@endsection