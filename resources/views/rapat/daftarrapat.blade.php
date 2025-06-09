@extends('layout.main')
@section('title', 'Daftar Rapat')

@section('content')
<div class="content-body">
    {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Daftar Rapat</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Daftar Rapat</h4>
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
            <h6 class="mg-b-5">Daftar Rapat</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Daftar Rapat yang telah dijadwalkan.</p>
     
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                   
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-7 mb-3">
                            <form action="/daftarrapat">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari judul rapat..." aria-label="Cari judul rapat.." aria-describedby="button-addon2" name="cari" value="{{request('cari')}}">
                                    <div class="input-group-append">
                                    <button class="btn btn-outline-light" type="submit" id="button-addon2">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    
                    
                    {{-- <form action="/isiabsenrapat"> --}}
                    <div class="row row-sm mg-b-25">
                        @foreach ($data as $item)
                            <div class="col-md-6 mb-5">
                            <div class="card card-event">
                                <div class="d-flex justify-content-left ml-2">
                                  {{-- <div class="tx-100 lh-1"><i class="icon ion-ios-calendar"></i></div> --}}
                                  {{-- <ion-icon name="bulb-outline"></ion-icon> --}}
                                  <i data-feather="calendar" class="wd-60 ht-60"></i>
                                </div>
                                {{-- <img src="{{ asset('images')}}/rapat.jpg" class="card-img-top" alt="" > --}}
                                
                                <div class="card-body tx-13">
                                <input type="text" value="{{$item->id_rapat}}" name="id_rapat" hidden>
                                <h5><a href="/isiabsenrapat/{{$item->id_rapat}}">{{$item->deskripsi}}</a></h5>
                                <p class="mg-b-0">{{date('j F Y',strtotime($item->tgl_rapat))}} Pukul : {{$item->time_in}} WIB  </p>
                                <span class="tx-12 tx-color-03">Tempat : {{$item->tempat}}</span>
                                <br>
                                
                                </div><!-- card-body -->
                                <div class="card-footer tx-13">
                                <span class="tx-color-03">{{ App\Models\PesertaRapat::where('id_rapat',$item->id_rapat)->count()}} orang peserta 
                                     
                                </span>
                                <span>
                                  @if ($item->foto)
                                    <a href="{{ $item->foto }}" class="btn btn-xs btn-success" target="_blank"><i data-feather="link"></i> Lihat Foto</a>
                                  @endif 
                                  <a href="/isiabsenrapat/{{$item->id_rapat}}" class="btn btn-xs btn-secondary">Masuk</a>
                                  {{-- <button type="submit" class="btn btn-xs btn-secondary">Masuk</button> --}}
                                </span>
                                </div><!-- card-footer -->
                            </div><!-- card -->
                            </div><!-- col -->

                         
                        @endforeach
                      </div><!-- row -->
                      {{-- </form> --}}
      
                </div><!-- col -->
                <div class="col-sm-7 col-md-5 col-lg-4 col-xl-3 mg-t-40 mg-lg-t-0">
                  <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h6 class="tx-uppercase tx-semibold mg-b-0">Acara Mendatang</h6>
                  </div>
                  <ul class="list-unstyled media-list mg-b-15">
                    @foreach ($agenda as $item2)
                        <li class="media align-items-center">
                          <div class="wd-40 ht-40 bg-dark tx-white d-flex align-items-center justify-content-center rounded">
                            <i data-feather="calendar"></i>
                          </div>
                          <div class="media-body pd-l-15 mb-2">
                            <h6 class="mg-b-2"><a href="/isiabsenrapat/{{$item2->id_rapat}}" class="link-01">{{$item2->deskripsi}}</a></h6>
                            <span class="tx-13 tx-color-03">{{date('j F Y',strtotime($item2->tgl_rapat))}} <br>Pukul : {{$item2->time_in}} WIB </span>
                          </div>
                          
                        </li>
                    @endforeach
                  </ul>
      
                  <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Rapat Berdasarkan Jenisnya</h6>
      
                  <nav class="nav nav-classic tx-13">
                    <a href="" class="nav-link"><span>Rapat Pembinaan</span> <span class="badge">{{ App\Models\Rapat::where('jenis_rapat','RP')->count()}}</span></a>
                    <a href="" class="nav-link"><span>Rapat Koordinasi</span> <span class="badge">{{ App\Models\Rapat::where('jenis_rapat','RK')->count()}}</span></a>
                    <a href="" class="nav-link"><span>Rapat Evaluasi</span> <span class="badge">{{ App\Models\Rapat::where('jenis_rapat','RM')->count()}}</span></a>
                    <a href="" class="nav-link"><span>Rapat Lainnya</span> <span class="badge">{{ App\Models\Rapat::where('jenis_rapat','RL')->count()}}</span></a>
                  </nav>
                </div><!-- col -->
              </div><!-- row -->
              {{-- <div class="d-flex justify-content-end"> --}}
                  {{$data->links()}}
              {{-- </div> --}}
          </><!-- card-body -->
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
@endsection