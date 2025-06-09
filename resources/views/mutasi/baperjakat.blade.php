@extends('layout.main')
@section('title', 'Catatan Baperjakat')

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
                        <li class="breadcrumb-item active" aria-current="page">Catatan Baperjakat</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Catatan Baperjakat</h4>
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
                        <h6 class="mg-b-5">Catatan Baperjakat</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Menambahkan catatan baperjakat </p>

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
                        <form method="POST" action="{{ url('/savebaperjakat') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $pegawai->id }}" name="id">
                            <input type="hidden" value="{{ $id_detail }}" name="id_mutasi_detail">
                            <input type="hidden" value="{{ $jenis }}" name="jenis">
                            <input type="hidden" value="{{ $origin }}" name="origin">

                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="catatan">Catatan Baperjakat</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan Baperjakat">{{ $pegawai->catatan_baperjakat }}</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="catatan">Syarat Jabatan</label>
                                    <textarea name="syarat" class="form-control" rows="3" placeholder="Syarat Jabatan">{{ $pegawai->syarat_jabatan }}</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- <div class="form-group col-md-4">
                                    <label for="syarat">Syarat Jabatan</label>
                                    <input type="text" id="syarat" name="syarat" class="form-control" placeholder="Syarat Jabatan"
                                        value="{{ old('syarat', $pegawai->syarat_jabatan ) }}">
                                </div> --}}

                                <div class="form-group col-md-4">
                                    <label for="syarat">Status Usulan</label>
                                    <select name="status" class="form-control" required>
                                        <option value="diterima" {{ old('status', $pegawai->status_usulan ?? '') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="baperjakat" {{ old('status', $pegawai->status_usulan ?? '') == 'baperjakat' ? 'selected' : '' }}>Telaah Baperjakat</option>
                                        <option value="disetujui" {{ old('status', $pegawai->status_usulan ?? '') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ old('status', $pegawai->status_usulan ?? '') == 'rejected' ? 'selected' : '' }}>Tidak Disetujui</option>
                                        <option value="selesai" {{ old('status', $pegawai->status_usulan ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>Sedang menyimpan</div>
                                <div class="hide-text">
                                <i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Simpan</div>
                            </button>

                            <hr>
                            <h6 class="mg-b-5">Identitas Pegawai</h6>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->nip }}" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->nama }}" readonly>
                                </div>
                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->tempat_lahir }}" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" value="{{ $pegawai->tgl_lahir }}" readonly>
                                </div>

                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label>Golongan</label>
                                    <div>
                                        <select class="custom-select" disabled>
                                            <option value="">-- Pilih Golongan --</option>

                                            <optgroup label="Golongan I (Juru)">
                                                <option value="I/a" {{ $pegawai->golongan == 'I/a' ? 'selected' : '' }}>I/a - Juru Muda</option>
                                                <option value="I/b" {{ $pegawai->golongan == 'I/b' ? 'selected' : '' }}>I/b - Juru Muda Tingkat I</option>
                                                <option value="I/c" {{ $pegawai->golongan == 'I/c' ? 'selected' : '' }}>I/c - Juru</option>
                                                <option value="I/d" {{ $pegawai->golongan == 'I/d' ? 'selected' : '' }}>I/d - Juru Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan II (Pengatur)">
                                                <option value="II/a" {{ $pegawai->golongan == 'II/a' ? 'selected' : '' }}>II/a - Pengatur Muda</option>
                                                <option value="II/b" {{ $pegawai->golongan == 'II/b' ? 'selected' : '' }}>II/b - Pengatur Muda Tingkat I</option>
                                                <option value="II/c" {{ $pegawai->golongan == 'II/c' ? 'selected' : '' }}>II/c - Pengatur</option>
                                                <option value="II/d" {{ $pegawai->golongan == 'II/d' ? 'selected' : '' }}>II/d - Pengatur Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan III (Penata)">
                                                <option value="III/a" {{ $pegawai->golongan == 'III/a' ? 'selected' : '' }}>III/a - Penata Muda</option>
                                                <option value="III/b" {{ $pegawai->golongan == 'III/b' ? 'selected' : '' }}>III/b - Penata Muda Tingkat I</option>
                                                <option value="III/c" {{ $pegawai->golongan == 'III/c' ? 'selected' : '' }}>III/c - Penata</option>
                                                <option value="III/d" {{ $pegawai->golongan == 'III/d' ? 'selected' : '' }}>III/d - Penata Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan IV (Pembina)">
                                                <option value="IV/a" {{ $pegawai->golongan == 'IV/a' ? 'selected' : '' }}>IV/a - Pembina</option>
                                                <option value="IV/b" {{ $pegawai->golongan == 'IV/b' ? 'selected' : '' }}>IV/b - Pembina Tingkat I</option>
                                                <option value="IV/c" {{ $pegawai->golongan == 'IV/c' ? 'selected' : '' }}>IV/c - Pembina Utama Muda</option>
                                                <option value="IV/d" {{ $pegawai->golongan == 'IV/d' ? 'selected' : '' }}>IV/d - Pembina Utama Madya</option>
                                                <option value="IV/e" {{ $pegawai->golongan == 'IV/e' ? 'selected' : '' }}>IV/e - Pembina Utama</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Golongan</label>
                                    <input type="date" class="form-control" value="{{ $pegawai->tmt_golongan }}" readonly>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Asal</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label for="jabatan_lama">Jabatan Lama</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->jabatan_lama }}" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Jabatan</label>
                                    <input type="date" class="form-control" value="{{ $pegawai->tmt_jabatan_lama }}" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_asal">Satker Asal</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->satker_asal }}" readonly>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Tujuan</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label for="jabatan_baru">Jabatan Baru</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->jabatan_baru }}" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_tujuan">Satker Tujuan</label>
                                    <input type="text" class="form-control" value="{{ $pegawai->satker_tujuan }}" readonly>
                                </div>
                            </div>

                            <hr>
                            <div class = "form-row">
                                <div class="form-group col-md-8">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" readonly>{{ $pegawai->catatan }}</textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="file" >Dokumen pendukung: </label>
                                    @if ($pegawai->file_pendukung)
                                        <a class="btn btn-info" href="{{ asset('mutasi').'/'.$pegawai->file_pendukung }}" target="_blank">
                                            <i data-feather="download" class="wd-15 mg-r-5"></i> Unduh
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div><!-- container -->
    </div><!-- content -->

    <script type="text/javascript">
    </script>
@endsection
