@extends('layout.main')
@section('title', 'Absen Online')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Isi Absen Online</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Pengisian Absensi Online</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          
        </div>
      </div>

      {{--<div id="map"></div>--}}

      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card ">
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
            <h6 class="mg-b-5">Riwayat Absesi</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Absensi yang telah terekam.</p>
            
          </div><!-- card-header -->
          <div class="card-body pd-20">
              <form method="POST" action="/absen">
                  @csrf
              <?php $time=date("Hi"); ?>
              
              <input type="text" name="lokasinya" id="lokasinya" class="form-control" hidden placeholder="First name" >
                <button type="submit" @if ($time<0500 || $time>1000) disabled @endif name="submit" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mb-2" value="btnIn"><i data-feather="log-in" class="wd-10 mg-r-5"></i> Isi Absensi Masuk</button>
                <button type="submit" @if ($time<1200 || $time>1400 ) disabled @endif name="submit" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5 mb-2" value="btnBreak"><i data-feather="at-sign" class="wd-10 mg-r-5"></i> Isi Absensi Istirahat</button>
                <button type="submit" @if ($time<1630 || $time>2000 ) disabled @endif name="submit" value="btnOut" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5 mb-2"><i data-feather="log-out" class="wd-10 mg-r-5"></i> Isi Absensi Pulang</button>
                <div class="table-responsive">
            </form>
                <table class="table mt-3" id="tabel">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Absen Masuk</th>
                            <th scope="col">Absen Istirahat</th>
                            <th scope="col">Absen Pulang</th>
                          
                            
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($Absen as $item)   
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{date('d-M-Y', strtotime($item->date))}}</td>
                            <td>{{$item->time_in}}
                                <br>Lokasi : {{$item->lok_in}}</td>
                            <td>{{$item->time_break}}
                              <br>Lokasi : {{$item->lok_break}}</td>
                            <td>{{$item->time_out}}
                              <br>Lokasi : {{$item->lok_out}}</td>
                          
                
                        </tr>
                    @endforeach
                
                    </tbody>
                
                </table>
                <div id="map"></div>
                 
 
                <p class="card-text text-white" id="output"></p>
            </div>
  
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
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
    
<style>
    #map { 
        height: 200px;
    }
</style>

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
    var loadMap = function (id) {
      var PTA = [-6.9376, 107.6895];
      var map = L.map(id);
      var tile_url = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
      var layer = L.tileLayer(tile_url, {
          attribution: 'OSM'
      });
      map.addLayer(layer);
      map.setView(PTA, 19);
      
      map.locate({setView: true, watch: true}) /* This will return map so you can do chaining */
      .on('locationfound', function(e){
          console.log('leaflet', e.latitude, ' _ ', e.longitude);
          var marker = L.marker([e.latitude, e.longitude]).bindPopup('Your are here :)');
          var circle = L.circle([e.latitude, e.longitude], e.accuracy/2, {
              weight: 1,
              color: 'blue',
              fillColor: '#cacaca',
              fillOpacity: 0.2
          });
          map.addLayer(marker);
          map.addLayer(circle);
      })
      .on('locationerror', function(e){
          console.log(e);
          alert("Location access denied.");
      });
    };

    $( document ).ready(function() {
      //loadMap('map');
    });
  </script>

@endsection