@extends('layout.main')
@section('title', 'Tambah SKP')

@section('content')
<div class="content-body">
     {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">SKP</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Sasaran Kinerja Pegawai</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{url('/skp')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                    <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Tambah Sasaran Kinerja Pegawai</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Menambahkan SKP </p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="{{ url('/save_skp') }}" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama</label>
                                <select class="custom-select @error ('username') is-invalid @enderror" name="username" required>
                                    <option value="">- Silahkan Pilih -</option>
                                    @foreach ($user as $user)
                                    <option value="{{ $user->username }}"
                                        {{ old('username', $username) == $user->username ? 'selected' : '' }}
                                    >
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    @foreach ($list_tahun as $thn)
                                        <option value="{{ $thn }}" {{ (collect($tahun)->contains($thn)) ? 'selected':'' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Predikat Kinerja</label>
                                <select name="predikat_kinerja" class="form-control" required>
                                    <option value="">- Pilih Predikat -</option>
                                    <option value="Sangat Baik">Sangat Baik</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Kurang">Kurang</option>
                                    <option value="Sangat Kurang">Sangat Kurang</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Periode SKP</label>
                                <select name="periode_skp" class="form-control" required>
                                    <option value="">- Pilih Periode -</option>
                                    <option value="Rencana Awal Tahun">Rencana Awal Tahun</option>
                                    <option value="Triwulan I">Triwulan I</option>
                                    <option value="Triwulan II">Triwulan II</option>
                                    <option value="Triwulan III">Triwulan III</option>
                                    <option value="Triwulan IV">Triwulan IV</option>
                                    <option value="Tahunan">Tahunan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Upload File SKP (PDF, maksimal 2MB)</label>
                                <input type="file" name="file" class="form-control" accept=".pdf" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i data-feather="save" class="wd-20 mg-r-5"></i>Simpan
                        </button>
                    </form>
@endsection

