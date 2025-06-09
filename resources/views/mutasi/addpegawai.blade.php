@extends('layout.main')
@section('title', 'Tambah Pegawai Mutasi')

@section('content')
    <style>
        /* untuk menghilangkan spinner  */
        .spinner {
            display: none;
        }
    </style>

    <div class="content-body">
        {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai Mutasi</li>
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
                        <h6 class="mg-b-5">Tambah Permohonan</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Menambahkan permohonan mutasi </p>

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
                        <form method="POST" action="{{ url('/savemutasipegawai') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $id_detail }}" name="id_mutasi_detail">
                            <input type="hidden" value="{{ $jenis }}" name="jenis">

                            <hr>
                            <h6 class="mg-b-5">Identitas</h6>
                            <div class="form-row">
                                {{-- <div class="form-group col-md-4">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="NIP" required>
                                    @error ('nip')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div> --}}

                                <div class="form-group col-md-4">
                                    <label for="nip">NIP</label>
                                    <div class="input-group">
                                        <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="NIP" required>
                                        @error ('nip')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btnCariNip">Cari</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" placeholder="Nama Pegawai" required>
                                    @error ('nama')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-4">
                                    <label>Tempat Lahir</label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control @error ('tgl_lahir') is-invalid @enderror"
                                        name="tgl_lahir" id="tgl_lahir" value="{{old('tgl_lahir')}}" required>
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
                                                <option value="I/a">I/a - Juru Muda</option>
                                                <option value="I/b">I/b - Juru Muda Tingkat I</option>
                                                <option value="I/c">I/c - Juru</option>
                                                <option value="I/d">I/d - Juru Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan II (Pengatur)">
                                                <option value="II/a">II/a - Pengatur Muda</option>
                                                <option value="II/b">II/b - Pengatur Muda Tingkat I</option>
                                                <option value="II/c">II/c - Pengatur</option>
                                                <option value="II/d">II/d - Pengatur Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan III (Penata)">
                                                <option value="III/a">III/a - Penata Muda</option>
                                                <option value="III/b">III/b - Penata Muda Tingkat I</option>
                                                <option value="III/c">III/c - Penata</option>
                                                <option value="III/d">III/d - Penata Tingkat I</option>
                                            </optgroup>

                                            <optgroup label="Golongan IV (Pembina)">
                                                <option value="IV/a">IV/a - Pembina</option>
                                                <option value="IV/b">IV/b - Pembina Tingkat I</option>
                                                <option value="IV/c">IV/c - Pembina Utama Muda</option>
                                                <option value="IV/d">IV/d - Pembina Utama Madya</option>
                                                <option value="IV/e">IV/e - Pembina Utama</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Golongan</label>
                                    <input type="date" class="form-control @error ('tmt_golongan') is-invalid @enderror"
                                        name="tmt_golongan" id="tmt_golongan" value="{{old('tmt_golongan')}}" required>
                                    @error ('tmt_golongan')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Tanggal Pensiun</label>
                                    <input type="date" class="form-control"
                                        name="tanggal_pensiun" id="tanggal_pensiun" value="{{old('tanggal_pensiun')}}" required>
                                    @error ('tanggal_pensiun')
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
                                    <input type="text" id="jabatan_lama" name="jabatan_lama" class="form-control" value="{{ old('jabatan_lama') }}" placeholder="Jabatan Lama" required>
                                    @error ('jabatan_lama')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>TMT Jabatan</label>
                                    <input type="date" class="form-control @error ('tmt_jabatan_lama') is-invalid @enderror"
                                        name="tmt_jabatan_lama" id="tmt_jabatan_lama" value="{{ old('tmt_jabatan_lama') }}" required>
                                    @error ('tmt_jabatan_lama')
                                        <div class="invalid-feedback">
                                            {{$message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_asal">Satker Asal</label>
                                    <input type="text" id="satker_asal" name="satker_asal" class="form-control" value="{{ old('satker_asal') }}" placeholder="Satker Asal" required>
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
                                    <input type="text" id="jabatan_baru" name="jabatan_baru" class="form-control" value="{{ old('jabatan_baru') }}" placeholder="Jabatan Baru" required>
                                    @error ('jabatan_baru')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="satker_tujuan">Satker Tujuan</label>
                                    <input type="text" id="satker_tujuan" name="satker_tujuan" class="form-control" value="{{ old('satker_tujuan') }}" placeholder="Satker Tujuan" required>
                                    @error ('satker_tujuan')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class = "form-row">
                                <div class="form-group col-md-8">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="file" >Dokumen pendukung</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" name="file" :value="old('file')">
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
        document.getElementById("btnCariNip").addEventListener("click", function() {
            const nip = document.getElementById("nip").value;
            if (nip.trim() === "") {
                alert("Silakan isi NIP terlebih dahulu.");
                return;
            }

            // AJAX Fetch data
            $.ajax({
                url: "{{ route('cari.nip') }}",
                type: 'POST',
                data: {
                    nip: nip,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log(response.data);
                        var data = response.data;
                        $('#nama').val(data.gelar_depan + ' ' + data.nama_lengkap + ', ' + data.gelar_belakang);
                        $('#tempat_lahir').val(data.tempat_lahir);
                        $('#tgl_lahir').val(data.tanggal_lahir);
                        $('#golongan').val(data.golongan);
                        $('#tmt_golongan').val(data.tmt_golongan);
                        $('#jabatan_lama').val(data.jabatan);
                        $('#tmt_jabatan_lama').val(data.tmt_jabatan);
                        $('#satker_asal').val(data.satker);
                        $('#tanggal_pensiun').val(data.tanggal_pensiun);
                    } else {
                        console.log(response.data);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        alert('Pegawai tidak ditemukan.');
                    } else {
                        alert('Terjadi kesalahan saat mencari pegawai.');
                    }
                }
            });
        });
    </script>
@endsection
