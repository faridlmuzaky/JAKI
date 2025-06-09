@extends('layout.main')
@section('title', 'Edit Mutasi')

@section('content')
    <style>
        /* untuk menghilangkan spinner  */
        .spinner {
            display: none;
        }
    </style>

    <div class="content-body">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data Mutasi</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Mutasi</h4>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ url('/mutasi/'.$mutasi->jenis.'/list') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                </div>
            </div>

            {{-- Main Content  --}}
            <div class="col-lg-4 col-xl-12 mg-t-10">
                <div class="card">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h6 class="mg-b-5">Tambah Data Mutasi</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Menambahkan data mutasi </p>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div><!-- card-header -->

                    <div class="card-body pd-20">
                        <form method="POST" action="{{ url('/updatemutasi') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $mutasi->id }}">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="periode">Periode</label>
                                    <input type="text" id="periode" name="periode" class="form-control" value="{{ $mutasi->periode }}" placeholder="periode" required>
                                    @error ('periode')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control form-select" aria-label="Pilih Opsi" name="jenis" required>
                                        <option value="hakim" <?= ($mutasi->jenis == 'hakim') ? 'selected' : '' ?>>Hakim</option>
                                        <option value="kepaniteraan" <?= ($mutasi->jenis == 'kepaniteraan') ? 'selected' : '' ?>>Kepaniteraan</option>
                                        <option value="kesekretariatan" <?= ($mutasi->jenis == 'kesekretariatan') ? 'selected' : '' ?>>Kesekretariatan</option>
                                        <option value="jurusita" <?= ($mutasi->jenis == 'jurusita') ? 'selected' : '' ?>>Jurusita</option>
                                        <option value="jsp" <?= ($mutasi->jenis == 'jsp') ? 'selected' : '' ?>>Izin JSP</option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" class="form-control @error ('tgl_mulai') is-invalid @enderror"
                                        name="tgl_mulai" id="tgl_mulai" value="{{ $mutasi->tgl_mulai }}" required>
                                    @error ('tgl_mulai')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control @error ('tgl_akhir') is-invalid @enderror"
                                        name="tgl_akhir" id="tgl_akhir" value="{{ $mutasi->tgl_akhir }}" required>
                                    @error ('tgl_akhir')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="file" >Dokumen Pngumuman</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="file" name="file" value="old('file')" accept="application/pdf">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                        @error ('file')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('file') }}
                                            </div>
                                        @enderror
                                    </div>

                                    <script>
                                        document.getElementById("file").addEventListener("change", function() {
                                            let fileName = this.files[0] ? this.files[0].name : "Pilih File";
                                            this.nextElementSibling.innerText = fileName;
                                        });
                                    </script>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>Sedang menyimpan</div>
                                <div class="hide-text">
                                <i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Simpan</div>
                            </button>
                        </form>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div><!-- container -->
    </div><!-- content -->

    <script>

    </script>
@endsection
