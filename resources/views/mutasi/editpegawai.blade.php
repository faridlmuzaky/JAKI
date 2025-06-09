@extends('layout.main')
@section('title', 'Edit Pegawai Mutasi')

@section('content')
    <style>
        /* untuk menghilangkan spinner  */
        .spinner {
            display: none;
        }
    </style>

    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Pegawai Mutasi</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Pegawai Mutasi</h4>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{url('/mutasi/'.$jenis.'/'.$id_detail.'/pegawai')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                </div>
            </div>

            {{-- Main Content  --}}
            <div class="col-lg-4 col-xl-12 mg-t-10">
                <div class="card">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h6 class="mg-b-5">Edit Data Mutasi Pegawai</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Edit permohonan mutasi pegawai </p>

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
                        <form method="POST" action="{{ url('/updatemutasipegawai') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $data->id }}" name="id">
                            <input type="hidden" value="{{ $id_detail }}" name="id_mutasi_detail">
                            <input type="hidden" value="{{ $jenis }}" name="jenis">

                            <hr>
                            <h6 class="mg-b-5">Identitas</h6>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" class="form-control" value="{{ $data->nip }}" placeholder="NIP" required>
                                    @error ('nip')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="{{ $data->nama }}" placeholder="Nama Pegawai" required>
                                    @error ('nama')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ $data->tempat_lahir }}" placeholder="Tempat Lahir" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control @error ('tgl_lahir') is-invalid @enderror"
                                        name="tgl_lahir" id="tgl_lahir" value="{{ $data->tgl_lahir }}" required>
                                    @error ('tgl_lahir')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputAddress2">Golongan</label>
                                    <div>
                                        <select class="custom-select" name="golongan" id="golongan" required>
                                            <option value="">-- Pilih Golongan --</option>

                                            <optgroup label="Golongan I (Juru)">
                                                <option value="I/a" {{ $data->golongan == 'I/a' ? 'selected' : '' }}>I/a - Juru Muda</option>
                                                <option value="I/b" {{ $data->golongan == 'I/b' ? 'selected' : '' }}>I/b - Juru Muda Tingkat I</option>
                                                <option value="I/c" {{ $data->golongan == 'I/c' ? 'selected' : '' }}>I/c - Juru</option>
                                                <option value="I/d" {{ $data->golongan == 'I/d' ? 'selected' : '' }}>I/d - Juru Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan II (Pengatur)">
                                                <option value="II/a" {{ $data->golongan == 'II/a' ? 'selected' : '' }}>II/a - Pengatur Muda</option>
                                                <option value="II/b" {{ $data->golongan == 'II/b' ? 'selected' : '' }}>II/b - Pengatur Muda Tingkat I</option>
                                                <option value="II/c" {{ $data->golongan == 'II/c' ? 'selected' : '' }}>II/c - Pengatur</option>
                                                <option value="II/d" {{ $data->golongan == 'II/d' ? 'selected' : '' }}>II/d - Pengatur Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan III (Penata)">
                                                <option value="III/a" {{ $data->golongan == 'III/a' ? 'selected' : '' }}>III/a - Penata Muda</option>
                                                <option value="III/b" {{ $data->golongan == 'III/b' ? 'selected' : '' }}>III/b - Penata Muda Tingkat I</option>
                                                <option value="III/c" {{ $data->golongan == 'III/c' ? 'selected' : '' }}>III/c - Penata</option>
                                                <option value="III/d" {{ $data->golongan == 'III/d' ? 'selected' : '' }}>III/d - Penata Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan IV (Pembina)">
                                                <option value="IV/a" {{ $data->golongan == 'IV/a' ? 'selected' : '' }}>IV/a - Pembina</option>
                                                <option value="IV/b" {{ $data->golongan == 'IV/b' ? 'selected' : '' }}>IV/b - Pembina Tingkat I</option>
                                                <option value="IV/c" {{ $data->golongan == 'IV/c' ? 'selected' : '' }}>IV/c - Pembina Utama Muda</option>
                                                <option value="IV/d" {{ $data->golongan == 'IV/d' ? 'selected' : '' }}>IV/d - Pembina Utama Madya</option>
                                                <option value="IV/e" {{ $data->golongan == 'IV/e' ? 'selected' : '' }}>IV/e - Pembina Utama</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Golongan</label>
                                    <input type="date" class="form-control @error ('tmt_golongan') is-invalid @enderror"
                                        name="tmt_golongan" id="tmt_golongan" value="{{ $data->tmt_golongan }}" required>
                                    @error ('tmt_golongan')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Asal</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label for="jabatan_lama">Jabatan Lama</label>
                                    <input type="text" id="jabatan_lama" name="jabatan_lama" class="form-control" value="{{ $data->jabatan_lama }}" placeholder="Jabatan Lama" required>
                                    @error ('jabatan_lama')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Jabatan</label>
                                    <input type="date" class="form-control @error ('tmt_jabatan_lama') is-invalid @enderror"
                                        name="tmt_jabatan_lama" id="tmt_jabatan_lama" value="{{ $data->tmt_jabatan_lama }}" required>
                                    @error ('tmt_jabatan_lama')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_asal">Satker Asal</label>
                                    <input type="text" id="satker_asal" name="satker_asal" class="form-control" value="{{ $data->satker_asal }}" placeholder="Satker Asal" required>
                                    @error ('satker_asal')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Tujuan</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label for="jabatan_baru">Jabatan Baru</label>
                                    <input type="text" id="jabatan_baru" name="jabatan_baru" class="form-control" value="{{ $data->jabatan_baru }}" placeholder="Jabatan Baru" required>
                                    @error ('jabatan_baru')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_tujuan">Satker Tujuan</label>
                                    <input type="text" id="satker_tujuan" name="satker_tujuan" class="form-control" value="{{ $data->satker_tujuan }}" placeholder="Satker Tujuan" required>
                                    @error ('satker_tujuan')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class = "form-row">
                                <div class="form-group col-md-8">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3">{{ $data->catatan }}</textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="file" >Dokumen pendukung</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" name="file" value="old('file')">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                        @error ('file')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('file') }}
                                            </div>
                                        @enderror

                                        <script>
                                            document.getElementById("customFile").addEventListener("change", function() {
                                                let fileName = this.files[0] ? this.files[0].name : "Pilih File";
                                                this.nextElementSibling.innerText = fileName;
                                            });
                                        </script>
                                    </div>
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

    <script type="text/javascript">
    </script>
@endsection
