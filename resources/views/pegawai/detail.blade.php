@extends('layout.main')
@section('title', 'Detail Pegawai')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Pegawai</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Pegawai</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Detail Pegawai</h4>
            </div>
            <div class="d-none d-md-block">
                @if ($back)
                    <a href="{{url('/pegawai')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                @else
                    <button  class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" onclick="closeWindow()">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                    </button>
                @endif
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Detail Pegawai</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Detail Pegawai</p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data">
                        {{-- <div class="col-md-6 form-group">
                            <label for="name">Nama</label>
                            <input type="text" Name="name" class="form-control" readonly
                                value="{{ $pegawai->gelar_depan .' '. $pegawai->nama_lengkap .', '. $pegawai->gelar_belakang }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="name">NIP</label>
                            <input type="text" Name="name" class="form-control" readonly
                                value="{{ $pegawai->nip }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="name">Tempat, Tanggal Lahir</label>
                            <input type="text" Name="name" class="form-control" readonly
                                value="{{ $pegawai->tempat_lahir  .', '. $pegawai->tanggal_lahir }}">
                        </div> --}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" class="form-control" readonly
                                        value="{{ $pegawai->gelar_depan .' '. $pegawai->nama_lengkap .', '. $pegawai->gelar_belakang }}">
                                </div>
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" name="nip" class="form-control" readonly
                                        value="{{ $pegawai->nip }}">
                                </div>
                                <div class="form-group">
                                    <label for="ttl">Tempat, Tanggal Lahir</label>
                                    <input type="text" name="ttl" class="form-control" readonly
                                        value="{{ $pegawai->tempat_lahir  .', '. $pegawai->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <img src="{{ $pegawai->foto }}" alt="Foto Pegawai" class="img-fluid rounded" style="max-height: 220px;">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="name">TMT PNS</label>
                                <input type="text" Name="name" class="form-control" readonly
                                    value="{{ $pegawai->tmt_pns }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name">Tanggal Pensiun</label>
                                <input type="text" Name="name" class="form-control" readonly
                                    value="{{ $pegawai->tanggal_pensiun }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name">Pangkat Golongan</label>
                                <input type="text" Name="name" class="form-control" readonly
                                    value="{{ $pegawai->pangkat ." - ". $pegawai->golongan }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name">Jabatan</label>
                                <input type="text" Name="name" class="form-control" readonly
                                    value="{{ $pegawai->jabatan }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name">Satuan Kerja</label>
                                <input type="text" Name="name" class="form-control" readonly
                                    value="{{ $pegawai->satker }}">
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <div class="card-body pd-20">
                            <table class="table mt-3" id="tabel">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jabatan</th>
                                        <th>Satker</th>
                                        <th>TMT</th>
                                    </tr>
                                </thead>
                                    @foreach ($pegawai->list_jabatan as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{
                                                    in_array($row->jabatan, ['Panitera Muda', 'Kepala Subbagian']) ?
                                                    $row->jabatan . ', ' . $row->unit_kerja : $row->jabatan
                                                }}
                                            </td>
                                            <td>{{ $row->satker }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->tmt)->locale('id')->isoFormat('D MMMM Y')  }}</td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>

    </div><!-- container -->
</div>
</div><!-- content -->

<script type="text/javascript">
    function closeWindow() {
        window.close();
    }
</script>
@endsection
