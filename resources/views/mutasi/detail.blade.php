@extends('layout.main')
@section('title', 'Mutasi Detail')

@section('content')
    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengajuan Mutasi</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Pengajuan Mutasi</h4>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ url('/mutasi/'.$jenis.'/list') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                    @if ($aktif)
                        <a href="{{ url('/addmutasidetail/'.$jenis.'/'.$id_mutasi )}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                            <i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Pengajuan Mutasi</a>
                    @endif
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
                        <h6 class="mg-b-5">{{ $periode }}</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Data pengajuan mutasi yang telah diinput.</p>
                    </div>
                    <!-- card-header -->

                    <div class="table-responsive">
                        <div class="card-body pd-20">
                            <table class="table mt-3 table-striped" id="tabel">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Periode</th>
                                        <th scope="col">Satker</th>
                                        <th scope="col">Tanggal Periode</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ url('mutasi/'.$jenis.'/'.$item->id.'/pegawai') }}">{{ $item->periode }}</a>
                                        </td>
                                        <td>{{ $item->nama_satker }}</td>
                                        <td>
                                            {{ $item->tgl_mulai }}
                                            <br>s/d
                                            <br>{{ $item->tgl_akhir }}
                                        </td>
                                        <td>
                                            @if ($item->doc_pengumuman)
                                                <div class="mb-1">
                                                    <a class="btn-sm btn-info" href="{{ asset('mutasi').'/'.$item->doc_pengumuman }}" target="_blank">
                                                        <i data-feather="download" class="wd-15 mg-r-5"></i> Pengumuman
                                                    </a>
                                                </div>
                                            @endif

                                            @if ($item->sk_baperjakat)
                                                <div class="mb-1">
                                                    <a class="btn-sm btn-success  mb-2" href="{{ asset('mutasi').'/'.$item->sk_baperjakat }}" target="_blank">
                                                        <i data-feather="download" class="wd-15 mg-r-5"></i> SK
                                                    </a>
                                                </div>
                                            @endif

                                            @if ($item->lampiran_sk)
                                                <div>
                                                    <a class="btn-sm btn-warning" href="{{ asset('mutasi').'/'.$item->lampiran_sk }}" target="_blank">
                                                        <i data-feather="download" class="wd-15 mg-r-5"></i> Lampiran
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="list"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ url('mutasi/'.$jenis.'/'.$item->id.'/pegawai') }}">
                                                        <i data-feather="folder-plus" class="wd-15 mg-r-5"></i>Pegawai
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form method="post" action="{{ url('mutasi/detail/hapus') }}">
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
                responsive: true,
                language: {
                    searchPlaceholder: 'Cari...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
    </script>
@endsection
