@extends('layout.main')
@section('title', 'Tambah PCK')

@section('content')
<div class="content-body">
     {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Penilaian Capaian Kinerja</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Penilaian Capaian Kinerja</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{url('/kinerja')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Edit Penilaian Capaian Kinerja</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Mengubah Data Penilaian Capaian Kinerja </p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="{{ url('/kinerja/update') }}" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama</label>
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="file_existing" value="{{ $data->file }}">
                                <input type="hidden" name="username" value="{{ $data->username }}">
                                <select class="custom-select" id="username" disabled>
                                    <option value="0">- Silahkan Pilih -</option>
                                    @foreach ($user as $user)
                                        <option value="{{$user->username}}" {{ (collect($data->username)->contains($user->username)) ? 'selected':'' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nilai (desimal gunakan tanda titik)</label>
                                <input type="number" step="any" class="form-control" id="nilai" name="nilai" placeholder="nilai" value="{{ $data->nilai }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    @foreach ($list_bulan as $key => $value)
                                        <option value="{{ $key }}" {{ (collect($data->bulan)->contains($key)) ? 'selected':'' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    @foreach ($list_tahun as $thn)
                                        <option value="{{ $thn }}" {{ (collect($data->tahun)->contains($thn)) ? 'selected':'' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                                <div class="form-group col-md-6 ">
                                <label>Dokumen PCK : </label>
                                <label>
                                    <a href="{{ url('/pck/') }}/{{ $data->file }}" target="_blank" class="btn btn-sm btn-info">Lihat File</a>
                                </label>

                                <div class="custom-file mb-3">
                                    <input type="file" accept="application/pdf" class="custom-file-input" id="file" name="file">
                                    <label class="custom-file-label" for="customFile">Choose File</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i data-feather="save" class="wd-20 mg-r-5"></i>Simpan
                        </button>
                    </form>
@endsection

