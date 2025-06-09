@extends('layout.main')
@section('title', 'SKP')

@section('content')
<div class="content-body">
    {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SKP Ketua</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Sasaran Kinerja Pegawai (Ketua Pengadilan)</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ url('/skp/add_skp/kpa') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                    <i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah SKP
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
                    <p class="tx-12 tx-color-03 mg-b-0">Sasaran Kinerja Pegawai yang telah diinput.</p>

                    <br>
                    <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <div class="mr-1">
                                <label>Tahun </label>
                            </div>
                            <select name="tahun" id="tahun" class="form-control">
                                @foreach ($list_tahun as $thn)
                                <option value="{{ $thn }}" {{ (collect($tahun)->contains($thn)) ? 'selected':'' }}>
                                    {{ $thn }}
                                </option>
                                @endforeach
                            </select>

                            <div class="ml-2 mr-1">
                                <label>Periode </label>
                            </div>
                            <select name="periode_skp" class="form-control" id="periode">
                                @foreach(['Rencana Awal Tahun', 'Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV', 'Tahunan'] as $periode)
                                    <option value="{{ $periode }}" {{ $periode_select == $periode ? 'selected' : '' }}>
                                        {{ $periode }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <a href="#" class="btn btn-primary mb-2" onclick="filter()">Filter</a>
                        <a href="#" class="btn btn-danger mb-2 ml-2" onclick="hapus_filter()">Hapus Filter</a>
                    </form>
                </div>
                <!-- card-header -->

                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tabel">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Nama</th>
                                    <td>Satuan Kerja</td>
                                    <th>Predikat</th>
                                    <th>Periode</th>
                                    <th>Tahun</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($skp as $skp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $skp->name }}
                                        @if ($skp->file_ttd_kpta)
                                        <a href="#" class="badge badge-success">Sudah di TTE</a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $skp->jabatan }} <br/>
                                        {{ $skp->nama_satker }}
                                    </td>
                                    <td>{{ $skp->predikat_kinerja }}</td>
                                    <td>{{ $skp->periode_skp }}</td>
                                    <td>{{ $skp->tahun }}</td>
                                    <td>
                                        @if ($skp->periode_skp)
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i data-feather="list"></i>
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ url('/skp/download/') }}/{{ encrypt($skp->id) }}" target="_blank">
                                                        <i data-feather="download" class="wd-15 mg-r-5"></i> Download SKP
                                                    </a>

                                                    <div class="dropdown-divider"></div>
                                                    @if ($skp->file_ttd_kpta)
                                                        <a class="dropdown-item" href="{{ url('/skp/signed/') }}/{{ encrypt($skp->id) }}" target="_blank">
                                                            <i data-feather="download" class="wd-15 mg-r-5"></i> SKP Signed
                                                        </a>
                                                    @endif

                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="/skp/{{ encrypt($skp->id) }}/edit">
                                                        <i data-feather="edit" class="wd-15 mg-r-5"></i> Edit
                                                    </a>

                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" onclick="hapus({{ $skp->id }}, '{{ $jenis }}')">
                                                        <i data-feather="trash" class="wd-15 mg-r-5"></i>Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- card-body -->
                </div><!-- table -->
            </div><!-- card -->
        </div><!-- Main -->
    {{-- </div><!-- container --> --}}
</div><!-- content body -->

<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapus">Hapus Data Sasaran Kinerja Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ url('/hapus_skp') }}">
                    @csrf

                    <input type="hidden" id="id_skp" name="id_skp">
                    <input type="hidden" id="jenis" name="jenis">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-exclamation-triangle"></i>
                        Hapus
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tabel').dataTable({
        // responsive:true
        "drawCallback": function (settings) {
            feather.replace();

        },
        responsive: true,
        language: {
            searchPlaceholder: 'Cari...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });

    function hapus(id, jenis) {
        $('#id_skp').val(id);
        $('#jenis').val(jenis);
        $('#ModalHapus').modal('toggle');
        $('#ModalHapus').modal('show');
    }

    function filter() {
        var tahun = $("#tahun").val();
        var periode = $("#periode").val();
        var url = 'skpkpa?tahun=' + tahun + '&periode=' + periode;
        window.location.href = url;
    }
    function hapus_filter() {
        window.location.href = 'skpkpa';
    }
</script>
@endsection
