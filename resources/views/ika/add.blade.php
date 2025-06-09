@extends('layout.main')
@section('title', 'Tambah IKA')

@section('content')
<div class="content-body">
     {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Izin Keluar Kantor</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Izin Keluar Kantor</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{url('/ika')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Tambah Izin Keluar Kantor</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Menambahkan Izin Keluar Kantor </p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="{{ url('/save_ika') }}" class="needs-validation" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Penandatangan</label>
                                <select class="custom-select" id="ttd" name="ttd">
                                    <option value="0">- Silahkan Pilih -</option>
                                    @foreach ($ttd as $ttd)
                                    <option value="{{ $ttd->name }}|{{ $ttd->jabatan }}">
                                        {{ $ttd->name ." - ". $ttd->jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Yang Mengajukan IKA</label>
                                <select class="custom-select" id="pegawai" name="pegawai">
                                    <option value="0">- Silahkan Pilih -</option>
                                    @foreach ($user as $user)
                                    <option value="{{ $user->username }}|{{ $user->name }}">
                                        {{ $user->name ." - ". $user->jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Keperluan IKA</label>
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Keperluan">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Tanggal</label>
                                <input type="date" class="form-control @error ('tgl_awal') is-invalid @enderror" name="tgl_awal"
                                    id="tgl_awal" placeholder="" :value="old('tgl_awal')" value="{{old('tgl_awal')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Jam</label>
                                <input type="time" class="form-control" name="jam_awal" id="jam_awal">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Sampai</label>
                                <input type="time" class="form-control" name="jam_akhir" id="jam_akhir">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i data-feather="save" class="wd-20 mg-r-5"></i>Simpan
                        </button>
                    </form>
@endsection

