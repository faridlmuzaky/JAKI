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
            </div>

            {{-- Main Content  --}}

            <form method="POST" action="/apel">
                @csrf
                <?php $time = date('Hi'); ?>
                <?php $muncul = false ?>

                <div
                    @if (
                            $muncul ||
                            (
                                ( (date('D') == 'Mon') && ($time > '0745' && $time < '0900') )
                                ||
                                ( (date('D') == 'Fri') && ($time > '1600' && $time < '1800') )
                            )
                        )
                        style="display:block;"
                    @else
                        style="display:none;"
                    @endif
                >
                    <div id="map"></div>
                    <div class="mt-2 mb-2">
                        Koordinat anda : <input type="text" name="lokasinya" id="lokasinya" class="form-control"
                            placeholder="First name" readonly>
                    </div>

                    @if ($muncul || (date('D') == 'Mon'))
                        @if ($muncul || ($time > '0745' && $time < '0900'))
                            <button type="submit" name="submit"
                                class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mb-2" value="btnIn"><i
                                    data-feather="log-in" class="wd-10 mg-r-5"></i> Isi Presensi Apel</button>
                        @endif
                    @elseif (date('D') == 'Fri')
                        @if ($time > '1600' && $time < '1800')
                            <button type="submit" name="submit"
                                class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mb-2" value="btnIn"><i
                                    data-feather="log-in" class="wd-10 mg-r-5"></i> Isi Presensi Apel</button>
                        @endif
                    @endif
                </div>
            </form>

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
                        <h6 class="mg-b-5">Riwayat Presensi</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Presensi apel yang telah terekam.</p>
                    </div>

                    <div class="card-body pd-20">

                        <div class="table-responsive">
                            <table class="table mt-3" id="tabel">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Jenis Apel</th>
                                        <th scope="col">Waktu Presensi</th>
                                        <th scope="col">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Absen as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-M-Y', strtotime($item->date)) }}</td>
                                            <td>
                                                @if ($item->type == '1')
                                                    Apel Pagi
                                                @else
                                                    Apel Sore
                                                @endif
                                            </td>
                                            <td>{{ $item->time_in }}</td>
                                            <td><a href="https://www.google.com/maps/search/?api=1&amp;query={{ $item->location }}"
                                                    target="_blank">{{ $item->location }}</td>
                                            {{-- <td>{{$item->Foto}}</td> --}}

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
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
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
        });
    </script>

    <script>
        var lok = document.getElementById("lokasinya");
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
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

        map.locate({
                setView: true
            })
            .on('locationerror', function(e) {
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
