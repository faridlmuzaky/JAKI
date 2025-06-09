@extends('layout.main')
@section('title', 'Kinerja')

@section('content')
<div class="content-body">
    {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Penilaian Capaian Kinerja</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Penilaian Capaian Kinerja Pegawai Bulanan</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ url('/kinerja/add_pck') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                    <i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah PCK
                </a>
            </div>
        </div>

        {{-- Main Content --}}
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
                    <h6 class="mg-b-5"> </h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Penilaian capaian kinerja yang telah diinput.</p>

                    <br>
                    <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <select name="filter_bulan" id="filter_bulan" class="form-control">
                                @foreach ($list_bulan as $key => $value)
                                    <option value="{{ $key }}" {{ (collect($bulan)->contains($key)) ? 'selected':'' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <select name="filter_tahun" id="filter_tahun" class="form-control">
                                @foreach ($list_tahun as $thn)
                                    <option value="{{ $thn }}" {{ (collect($tahun)->contains($thn)) ? 'selected':'' }}>
                                        {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <a href="#" class="btn btn-primary mb-2" onclick="filter()">Filter Bulan</a>
                        <a href="#" class="btn btn-danger mb-2 ml-2" onclick="hapus_filter()">Hapus Filter</a>
                        @if (Auth::User()->role == 1)
                            <a class="btn btn-info mb-2 ml-2" href="/kinerja/blast_wa">
                                <i data-feather="send" class="wd-15 mg-r-5"></i>Kirim WA
                            </a>
                        @endif
                    </form>
                </div>
                <!-- card-header -->

                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tabel">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Satker</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pck as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="#">{{ $item->name }}</a>
                                        {{-- <br>{{ $item->username }} --}}
                                    </td>
                                    <td>
                                        {{ $item->bantu ? $item->bantu . ' (Perbantuan)' : $item->nama_satker }}
                                    </td>
                                    <td>
                                        {{ $item->bulan .' '. $item->tahun }}
                                    </td>
                                    <td>{{ $item->nilai }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="list"></i>
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($item->id)
                                                <a class="dropdown-item" href="{{ url('/pck/') }}/{{ $item->file }}" target="_blank">
                                                    <i data-feather="printer" class="wd-15 mg-r-5"></i>Cetak PCK</a>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="/kinerja/{{ $item->id }}/edit"><i
                                                    data-feather="edit" class="wd-15 mg-r-5"></i>Edit</a>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" onclick="hapus({{ $item->id }})"><i
                                                    data-feather="trash" class="wd-15 mg-r-5"></i>Hapus</a>
                                                @else
                                                    @if (Auth::User()->role == 1)
                                                        <a class="dropdown-item" href="/kinerja/{{ $item->username }}/wa"><i
                                                            data-feather="send" class="wd-15 mg-r-5"></i>Kirim WA</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- card-body -->
                </div><!-- table -->
            </div><!-- card -->
        </div><!-- Main -->
    </div><!-- container -->
</div><!-- content body -->

<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapus">Hapus Data Izin Keluar Kantor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ url('/hapus_pck') }}">
                    @csrf
                    <input type="hidden" id="id_pck" name="id_pck">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-exclamation-triangle"></i>
                        Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tabel').dataTable({
        "drawCallback": function (settings) {
            feather.replace();
        },
        responsive: true,
        language: {
            searchPlaceholder: 'Cari...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


    function hapus(id) {
        $('#id_pck').val(id);
        $('#ModalHapus').modal('toggle');
        $('#ModalHapus').modal('show');
    }

    function filter() {
        var bulan = $("#filter_bulan").val();
        var tahun = $("#filter_tahun").val();
        var url = 'kinerja?bulan=' + bulan + '&tahun=' + tahun;
        window.location.href = url;
    }
    function hapus_filter() {
        window.location.href = 'kinerja';
    }
</script>
@endsection
