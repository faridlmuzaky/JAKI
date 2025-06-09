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
                    <h6 class="mg-b-5">Tambah Penilaian Capaian Kinerja</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Menambahkan Penilaian Capaian Kinerja </p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="{{ url('/save_pck') }}" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama</label>
                                <select class="custom-select @error ('username') is-invalid @enderror" id="username" name="username">
                                    <option value="">- Silahkan Pilih -</option>
                                    @foreach ($user as $user)
                                    <option value="{{ $user->username }}" {{ old('username') == $user->username ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error ('username')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('username') }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nilai (desimal gunakan tanda titik)</label>
                                <input type="number" step="any" class="form-control @error ('nilai') is-invalid @enderror"
                                    id="nilai" name="nilai" placeholder="nilai" value="{{ old('nilai') }}" required>
                                @error ('nilai')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nilai') }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    @foreach ($list_bulan as $key => $value)
                                        <option value="{{ $key }}" {{ (collect($bulan)->contains($key)) ? 'selected':'' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
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
                            <div class="form-group col-md-6 ">
                                <label for="inputPassword3" >Dokumen PCK (Besar File Maksimal 2 MB)</label>
                                <div class="custom-file mb-3">
                                    <input type="file" accept="application/pdf" class="custom-file-input @error ('file') is-invalid @enderror"
                                        id="file" name="file">
                                    <label class="custom-file-label" for="customFile">Choose File</label>
                                    @error ('file')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i data-feather="save" class="wd-20 mg-r-5"></i>Simpan
                        </button>
                    </form>
    <script type="text/javascript">
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endsection

