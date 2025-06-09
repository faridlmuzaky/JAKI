@extends('layout.main')
@section('title', 'Daftar Mutasi')

@section('content')
    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mutasi</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Mutasi</h4>
                </div>
                <div class="d-flex justify-content-end">
                    @if (Auth::User()->role==1)
                        <a href="{{url('/addmutasi/'.$jenis)}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                            <i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Mutasi</a>
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
                        <p class="tx-12 tx-color-03 mg-b-0">Data mutasi yang telah diinput.</p>
                    </div>
                    <!-- card-header -->

                    <div class="table-responsive">
                        <div class="card-body pd-20">
                            <table class="table mt-3 table-striped" id="tabel">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Periode</th>
                                        <th scope="col">Tanggal Periode</th>
                                        <th scope="col">Pengumuman</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($mutasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ url('mutasi/'.$item->jenis.'/'.$item->id.'/detail') }}">{{ $item->periode }}</a>
                                        </td>
                                        <td>
                                            {{ $item->tgl_mulai }}
                                            <br>s/d
                                            <br>{{ $item->tgl_akhir }}
                                        </td>
                                        <td>
                                            @if ($item->doc_pengumuman)
                                                <a class="btn btn-success" href="{{ asset('mutasi').'/'.$item->doc_pengumuman }}" target="_blank">
                                                    <i data-feather="download" class="wd-15 mg-r-5"></i> Unduh
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="list"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ url('mutasi/'.$item->jenis.'/'.$item->id.'/detail') }}">
                                                        <i data-feather="folder-plus" class="wd-15 mg-r-5"></i>Detail
                                                    </a>

                                                    @if (Auth::User()->role==1)
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{ url('mutasi/'.$item->jenis.'/'.$item->id.'/allpegawai') }}">
                                                        <i data-feather="users" class="wd-15 mg-r-5"></i>Pegawai
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{ url('mutasi/'.$item->jenis.'/'.$item->id.'/edit') }}">
                                                        <i data-feather="edit" class="wd-15 mg-r-5"></i>Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form method="post" action="{{ url('mutasi/hapus') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="hidden" name="jenis" value="{{ $item->jenis }}">
                                                        <button class="dropdown-item" type="submit">
                                                            <i data-feather="trash" class="wd-15 mg-r-5"></i>Hapus
                                                        </button>
                                                    </form>
                                                    @endif
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
