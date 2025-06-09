@extends('layout.main')
@section('title', 'Mutasi Pegawai')

@section('content')
    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Pegawai Yang Diajukan Mutasi</h4>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{url('/mutasi/'.$jenis.'/list')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
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
                        <h6 class="mg-b-5">Data Mutasi</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Data pengajuan mutasi yang telah diinput.</p>
                    </div>
                    <!-- card-header -->

                    <div class="table-responsive">
                        <div class="card-body pd-20">
                            <table class="table table-striped table-bordered mt-3" id="tabel">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="200">Identitas</th>
                                        <th scope="col" width="200">Jabatan Lama</th>
                                        <th scope="col" width="200">Jabatan Baru</th>
                                        <th scope="col" width="200">Catatan</th>
                                        <th scope="col" width="110">Dok Pendukung</th>
                                        <th scope="col" width="200">Permohonan dan Riwayat</th>
                                        <th scope="col" width="80">Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->nama }}
                                            <br/>NIP: {{ $item->nip }}
                                            <hr/>Golongan: {{ $item->golongan }}
                                            <br>TMT Gol. : {{ $item->tmt_jabatan_lama }}
                                        </td>
                                        <td>
                                            {{ $item->jabatan_lama }}
                                            <br>TMT: {{ $item->tmt_jabatan_lama }}
                                            <br>Satker: {{ $item->satker_asal }}
                                        </td>
                                        <td>
                                            {{ $item->jabatan_baru }}
                                            <br>Satker: {{ $item->satker_tujuan }}
                                        </td>
                                        <td>
                                            {{ $item->catatan }}
                                        </td>
                                        <td>
                                            @if ($item->file_pendukung)
                                                <a class="btn-sm btn-success" href="{{ asset('mutasi').'/'.$item->file_pendukung }}" target="_blank">
                                                    <i data-feather="download" class="wd-15 mg-r-5"></i> Unduh
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            Usulan: {{ $item->tgl_usulan }}
                                            <br/>Status Usulan:
                                            <br/>{{ $item->status_usulan }}
                                            <hr/>Catatan Baperjakat:
                                            <br/>{{ $item->catatan_baperjakat }}
                                            <br/>Syarat Jabatan:
                                            <br/>{{ $item->syarat_jabatan }}
                                            <br>
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="list"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (Auth::User()->role==1)
                                                    <a class="dropdown-item" href="{{ url('mutasi/'.$jenis.'/'.$item->id.'/baperjakat/allpegawai') }}">
                                                        <i data-feather="edit" class="wd-15 mg-r-5"></i>Baperjakat
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    @endif
                                                    <form method="post" action="{{ url('mutasi/allpegawai/hapus') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                                                        <button class="dropdown-item" type="submit">
                                                            <i data-feather="trash" class="wd-15 mg-r-5"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div><!-- card-body -->
                    </div>
                </div><!-- card -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

    <script>
        $('#tabel').dataTable({
        // responsive:true
        "drawCallback": function(settings) {
            feather.replace();
        },
            scrollX: true,
            responsive: true,
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
    </script>
@endsection
