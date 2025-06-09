@extends('layout.main')
@section('title', 'Slip Gaji')

@section('content')
<div class="content-body">
   {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Slip Gaji</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Slip Gaji, Tunjangan Kinerja dan Uang Makan</h4>
            </div>
            <div class="d-flex justify-content-end">
                {{-- <a href="{{url('/addizbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i
                        data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Data Cuti</a> --}}
                {{-- <a href="{{url('/addusulctuser')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i
                        data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Usulan</a> --}}
                {{-- <button type="submit" class="btn btn-success"><i data-feather="plus"
                        class="wd-10 mg-r-5"></i>Tambah Data Cuti</button> --}}

            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card mb-3">
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

                    <h6 class="mg-b-5">Slip Gaji</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Slip gaji yang telah diinput oleh bagian keuangan.</p>

                </div><!-- card-header -->
                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tbl-gaji">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col" class="text-center">Netto</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($gaji as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="#">{{$item->nama}}</a>
                                    <br>{{$item->nip}}
                                </td>
                                <td>
                                    {{$item->bulan}}
                                    {{$item->tahun}}
                                </td>
                                <td class="text-center">{{ number_format($item->jumlah) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="list"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ url('/cetakgaji/') .'/'. $item->id }}"><i
                                                    data-feather="printer" class="wd-15 mg-r-5"></i>Cetak
                                            </a>
                                            {{-- <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="{{ url('/detailgaji/') .'/'. $item->id }}" target="_blank"><i
                                                    data-feather="file-text" class="wd-15 mg-r-5"></i>Detail
                                            </a> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

            <div class="card mb-3">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Slip Tukin</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Slip tukin yang telah diinput oleh bagian keuangan.</p>
                </div>

                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tbl-tukin">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col" class="text-center">Netto</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($tukin as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="#">{{$item->nama}}</a>
                                    <br>{{$item->nip}}
                                </td>
                                <td>
                                    {{$item->bulan}}
                                    {{$item->tahun}}
                                </td>
                                <td class="text-center">{{ number_format($item->netto) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="list"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ url('/cetaktukin/') .'/'. $item->id }}"><i
                                                    data-feather="printer" class="wd-15 mg-r-5"></i>Cetak
                                            </a>
                                            {{-- <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="{{ url('/detailtukin/') .'/'. $item->id }}" target="_blank"><i
                                                    data-feather="file-text" class="wd-15 mg-r-5"></i>Detail
                                            </a> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

            <div class="card mb-3">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Slip Uang Makan</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Slip uang makan yang telah diinput oleh bagian keuangan.</p>
                </div>

                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tbl-um">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col" class="text-center">Netto</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($um as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="#">{{$item->nama}}</a>
                                    <br>{{$item->nip}}
                                </td>
                                <td>
                                    {{$item->bulan}}
                                    {{$item->tahun}}
                                </td>
                                <td class="text-center">{{ number_format($item->jumlah) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="list"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ url('/cetakum/') .'/'. $item->id }}"><i
                                                    data-feather="printer" class="wd-15 mg-r-5"></i>Cetak
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div><!-- container -->
    </div>
</div><!-- content -->

<script>
    $('#tbl-gaji').dataTable({
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

    $('#tbl-tukin').dataTable({
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

    $('#tbl-um').dataTable({
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
</script>
@endsection
