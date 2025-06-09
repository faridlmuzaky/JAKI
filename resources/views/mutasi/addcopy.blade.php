@extends('layout.main')
@section('title', 'Tambah Mutasi')

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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Mutasi</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Mutasi</h4>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{url('/usulmutasi')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
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
                        <form method="POST" action="{{ url('/savemutasi') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label for="jenis_mutasi">Jenis Mutasi</label>
                                    <select class="custom-select" name="jenis_mutasi" id="jenis_mutasi">
                                        <option value ="" selected>- Pilih Jenis Mutasi -</option>
                                        <option value="masuk">Masuk</option>
                                        <option value="keluar">Keluar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="NIP">
                                    @error ('nip')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" placeholder="Nama Pegawai" required>
                                    @error ('nama')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Asal</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label>Jenis Pengadilan Asal</label>
                                    <select class="custom-select" name="jenis_pengadilan" id="jenis_pengadilan" onchange="get_pt(event);">
                                        <option value ="" selected>- Pilih Jenis Pengadilan -</option>
                                        <option value="4">PENGADILAN AGAMA</option>
                                        <option value="1">PENGADILAN NEGERI</option>
                                        <option value="2">PENGADILAN MILITER</option>
                                        <option value="3">PENGADILAN TATA USAHA NEGARA</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputAddress2">Pengadilan Tinggi Asal</label>
                                    <div id="pt-asal">
                                        <select class="custom-select" name="pt_asal" id="pt_asal" onchange="get_pa(event);">
                                            <option value ="" selected>- Pilih Satker Tk. Banding -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress2">Satker Asal</label>
                                    <div id="satker-asal">
                                        <select class="custom-select" name="satker_asal" id="satker_asal">
                                            <option value ="" selected>- Pilih Satker Asal -</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="jabatan_asal">Jabatan Asal</label>
                                    <input type="text" id="jabatan_asal" name="jabatan_asal" class="form-control" value="{{ old('jabatan_asal') }}" placeholder="Jabatan Asal" required>
                                    @error ('jabatan_asal')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="mg-b-5">Satker Tujuan</h6>
                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label>Jenis Pengadilan Tujuan</label>
                                    <select class="custom-select" name="jenis_pengadilan_tujuan" id="jenis_pengadilan_tujuan" onchange="get_pt_tujuan(event);">
                                        <option value ="" selected>- Pilih Jenis Pengadilan -</option>
                                        <option value="4">PENGADILAN AGAMA</option>
                                        <option value="1">PENGADILAN NEGERI</option>
                                        <option value="2">PENGADILAN MILITER</option>
                                        <option value="3">PENGADILAN TATA USAHA NEGARA</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputAddress2">Pengadilan Tinggi Tujuan</label>
                                    <div id="pt-tujuan">
                                        <select class="custom-select" name="pt_tujuan" id="pt_tujuan" onchange="get_pa_tujuan(event);">
                                            <option value ="" selected>- Pilih Satker Tk. Banding -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress2">Satker Tujuan</label>
                                    <div id="satker-tujuan">
                                        <select class="custom-select" name="satker_tujuan" id="satker_tujuan">
                                            <option value ="" selected>- Pilih Satker Tujuan -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan_tujuan">Jabatan Tujuan</label>
                                    <input type="text" id="jabatan_tujuan" name="jabatan_tujuan" class="form-control" value="{{ old('jabatan_tujuan') }}" placeholder="Jabatan Tujuan" required>
                                    @error ('jabatan_tujuan')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="file" >Dokumen pendukung</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="file" name="file" :value="old('file')">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                        @error ('file')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('file') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>Sedang menyimpan</div>
                                <div class="hide-text">
                                <i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Kirimkan Permohonan</div>
                            </button>
                        </form>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div><!-- container -->
    </div><!-- content -->

    <script type="text/javascript">
        function get_pt(event) {
            var jenis_pengadilan = $("select#jenis_pengadilan option:selected").attr('value');

            $("#pt-asal").html("");
            var html = "";
            $.ajax({
                type: "GET",
                url: "{{ route('get_pt') }}",
                data: {
                    jenis_pengadilan: jenis_pengadilan
                },
                cache: false,
                success: function(data) {
                    html += '<select class="custom-select" name="pt_asal" id="pt_asal" onchange="get_pa(event);">';
                    html += '<option value ="" selected>- Pilih Satker Tk. Banding -</option>';

                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].nama + '</option>';
                    }

                    html += '</select>';

                    $("#pt-asal").html(html);
                }
            });
        }

        function get_pa(event) {
            // console.log(event.target.value);
            var pt_id = $("select#pt_asal option:selected").attr('value');
            $("#satker-asal").html("");
            var html = "";
            $.ajax({
                type: "GET",
                url: "{{ route('get_pa') }}",
                data: {
                    pt_id: pt_id
                },
                cache: false,
                success: function(data) {
                    html += '<select class="custom-select" name="satker_asal" id="satker_asal">';
                    html += '<option value ="" selected>- Pilih Satker Asal -</option>';

                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].nama + '</option>';
                    }

                    html += '</select>';

                    $("#satker-asal").html(html);
                }
            });
        }

        function get_pt_tujuan(event) {
            var jenis_pengadilan = $("select#jenis_pengadilan_tujuan option:selected").attr('value');

            $("#pt-tujuan").html("");
            var html = "";
            $.ajax({
                type: "GET",
                url: "{{ route('get_pt') }}",
                data: {
                    jenis_pengadilan: jenis_pengadilan
                },
                cache: false,
                success: function(data) {
                    html += '<select class="custom-select" name="pt_tujuan" id="pt_tujuan" onchange="get_pa_tujuan(event);">';
                    html += '<option value ="" selected>- Pilih Satker Tk. Banding -</option>';

                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].nama + '</option>';
                    }

                    html += '</select>';

                    $("#pt-tujuan").html(html);
                }
            });
        }

        function get_pa_tujuan(event) {
            // console.log(event.target.value);
            var pt_id = $("select#pt_tujuan option:selected").attr('value');
            $("#satker-tujuan").html("");
            var html = "";
            $.ajax({
                type: "GET",
                url: "{{ route('get_pa') }}",
                data: {
                    pt_id: pt_id
                },
                cache: false,
                success: function(data) {
                    html += '<select class="custom-select" name="satker_tujuan" id="satker_tujuan">';
                    html += '<option value ="" selected>- Pilih Satker Tujuan -</option>';

                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].nama + '</option>';
                    }

                    html += '</select>';

                    $("#satker-tujuan").html(html);
                }
            });
        }
    </script>
@endsection
