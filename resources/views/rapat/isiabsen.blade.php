@extends('layout.main')
@section('title', 'Presensi Apel')

@section('content')

<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Isi Presensi Apel</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Pengisian Presensi Apel</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          <button class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5" onclick="history.back()"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Kembali</button>
          
        </div>
    </div>
 
      {{-- Main Content  --}}

      <div id="map"></div>
      <form method="POST" action="/updateabsenrapat">
        @csrf   
      <div class="mt-2">
        Koordinat anda :  <input type="text" name="lokasinya" id="lokasinya" class="form-control"  placeholder="First name" readonly>
      </div>
            <div class="col-lg-4 col-xl-12 mg-t-10">
                <div class="card ">
                    
                    @foreach ($data as $item)
                            <class="card-header pd-t-20 pd-b-0 bd-b-0">
                                @if (session('status'))
                                        <div class="alert alert-success mx-2 mt-2">
                                            {{ session('status') }}
                                        </div>
                                @endif
                                @if (session('error'))
                                        <div class="alert alert-danger mx-2 mt-2">
                                            {{ session('error') }}
                                        </div>
                                @endif

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger mx-2 mt-2">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>Error : {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                        
                                <input type="text" name="id_rapat" value="{{$item->id_rapat}}" hidden>
                                
                                <div class="content content-fixed bd-b">
                                    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <div>
                                        <h4 class="mg-b-5">{{$item->deskripsi}}</h4>
                                        {{-- <p class="mg-b-0 tx-color-03">{{date('j F Y',strtotime($item->tgl_rapat))}} Pukul : {{$item->time_in}} WIB </p> --}}
                                        <p class="mg-b-0 ">{{date('j F Y',strtotime($item->tgl_rapat))}} Pukul : {{$item->time_in}} WIB </p>
                                        <p class="mg-b-0 text-primary">Waktu Presensi : {{$item->waktu_absen ? $item->waktu_absen.' WIB' : 'Kamu belum melakukan presensi'}}</p>
                                        </div>
                                        <div class="mg-t-20 mg-sm-t-0">
                                        {{-- <button class="btn btn-white"><i data-feather="printer" class="mg-r-5"></i> Print</button> --}}
                                        {{-- <button class="btn btn-white mg-l-5"><i data-feather="pencil" class="mg-r-5"></i> Isi Notula</button> --}}
                                        {{-- <a href="/isicatatan{{$item->id_rapat}}" class="btn btn-primary mg-l-6" type="submit"><i data-feather="edit-2" class="mg-r-5"></i> Isi Catatan</a> --}}
                                        @if ($item->notulis == Auth::user()->name)
                                          <a href="/isinotula/{{$item->id_rapat}}" class="btn btn-white mg-l-5"><i data-feather="pencil" class="mg-r-5"></i> Isi Notula {{$item->notulis}}</a>
                                        @endif
                                        @if (date("Y-m-d")==$item->tgl_rapat)
                                            <button class="btn btn-primary mg-l-6" type="submit"><i data-feather="credit-card" class="mg-r-5"></i> Isi Kehadiran</button>
                                        @endif
                                        </div>
                                    </div>
                                    </div><!-- container -->
                                </div><!-- content -->
                            <!-- card-header -->
                            <div class="card-body pd-20">
      
                                <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Kegiatan {{$item->deskripsi}}</label>
                                <h6 class="tx-15 mg-b-10">Notula :</h6>
                                {{-- <p class=""><textarea id="summernote" name="notula" disabled>{{$item->notulensi}}</textarea></p> --}}
                                <p class="">{!!$item->notulensi!!}</p>
                                <br>
                                <?php $time=date("Hi"); ?>
                                
                                

                                

                            </div><!-- card-body -->
                            <div class="card-footer">
                              <p class="mg-b-0">Pengadilan Tinggi Agama Bandung</p>
                                <p class="mg-b-0">Jl. Soekarno Hata No. 714 Bandug</p>
                                <p class="mg-b-0">Email: surat_ptajawabarat@gmail.com</p>
                            </div>
                    @endforeach
                
                </div><!-- card -->
            </div>
        </form>
    </div><!-- container -->
</div><!-- content -->  

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> --}}
    
    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Isi Absensi</h5>
           
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
           
          </div>
          <div class="modal-body">
            <form>
             
                <div class="form-group">
                    <select class="custom-select">
                        <option selected disabled>- Pilih -</option>
                        <option value="1">Absen Masuk</option>
                        <option value="2">Absen Istirahat</option>
                        <option value="3">Absen Pulang</option>
                      </select>
                </div>
              </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
          </div>
        </div>
      </div>
    </div>
    

<script type="text/javascript">
$(document).ready(function() {
    $('#tabel').DataTable();
} );
</script>

<script>

    var lok = document.getElementById("lokasinya");
    if (navigator.geolocation)
        {
        navigator.geolocation.getCurrentPosition(showPosition);
        }
    else{x.innerHTML = "Geolocation is not supported by this browser.";}

    function showPosition(position)
    {
      lok.value = position.coords.latitude + "," + position.coords.longitude
    }

       
  </script>

<script>


  var map = L.map('map').setView([-6.9479653, 107.7035441], 13);

  // var map = L.map("map", {
  //       centre: [51.450584 , -2.5946832],
  //       zoom: 12,
  //       gestureHandling: true
  //       });

 


  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);


  function onLocationFound(e) {
         var radius = e.accuracy / 2;
         var location = e.latlng
         L.marker(location).addTo(map)
         L.circle(location, radius).addTo(map);
      }

  map.on('locationfound', onLocationFound);

  map.locate({setView: true})
        .on('locationerror', function(e){
            console.log(e);
            alert("Location access has been denied.");
            document.getElementById("myBtn1").disabled = true;
            document.getElementById("myBtn2").disabled = true;
            document.getElementById("myBtn3").disabled = true;
        });
        
  L.control.locate().addTo(map);
  

  // lc.start();
</script>


@endsection