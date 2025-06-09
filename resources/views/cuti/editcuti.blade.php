@extends('layout.main')
@section('title', 'Edit Cuti')

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
                        <li class="breadcrumb-item active" aria-current="page">Edit Cuti</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Edit Permohonan Cuti</h4>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{url('/approvalcuti')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                    <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-4 col-xl-12 mg-t-10">
            <div class="card">
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h6 class="mg-b-5">Edit Permohonan</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Edit permohonan cuti </p>
                </div><!-- card-header -->
                <div class="card-body pd-20">
                    <form method="POST" action="{{ url('/updatecuti') }}" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">NIP</label>
                                <input type="text" name="nip" class="form-control" value="{{ $cuti->nip}}" readonly
                                    value="{{old('nip')}}">
                                @error ('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <input type="hidden" name="id" value="{{ $id}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Nama</label>
                                <input type="text" name="nama" readonly
                                    class="form-control @error ('nama') is-invalid @enderror" id="inputPassword4"
                                    :value="old('nama')" placeholder="Nama Pegawai" value="{{ $cuti->nama}}">
                                @error ('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Jabatan</label>
                                <input type="text" name="jabatan" readonly class="form-control"
                                    value="{{ $cuti->jabatan}}">
                                @error ('jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Satuan Kerja</label>
                                <input type="text" name="satker" readonly class="form-control"
                                    placeholder="Nama Pegawai" value="{{ $cuti->nama_satker }}">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 ">
                                <label>Jenis Cuti</label>
                                <select class="custom-select" name="jenis">
                                    <option value="">- Pilih Jenis Cuti -</option>
                                    <option value="CT" {{ $cuti->jenis_cuti=='CT' ? 'selected':'' }}>Cuti Tahunan
                                    </option>
                                    <option value="CB" {{ $cuti->jenis_cuti=='CB' ? 'selected':'' }}>Cuti Besar
                                    </option>
                                    <option value="CS" {{ $cuti->jenis_cuti=='CS' ? 'selected':'' }}>Cuti Sakit</option>
                                    <option value="CM" {{ $cuti->jenis_cuti=='CM' ? 'selected':'' }}>Cuti Bersalin
                                    </option>
                                    <option value="CAP" {{ $cuti->jenis_cuti=='CAP' ? 'selected':'' }}>Cuti Alasan
                                        Penting</option>
                                    <option value="CLTN" {{ $cuti->jenis_cuti=='CLTN' ? 'selected':'' }}>CTLN</option>
                                </select>
                                @error ('jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 ">
                                <label>Alasan Cuti</label>
                                <input type="text" class="form-control" name="alasan" placeholder="Alasan Cuti" value="{{ $cuti->alasan_cuti }}">
                                @error ('alasan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Alamat Cuti</label>
                            <textarea class="form-control" name="alamatcuti" rows="3">{{ $cuti->alamat_cuti }}</textarea>
                            @error ('alamatcuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label>Lama Cuti</label>
                                <input type="number" class="form-control" name="lama" placeholder="Lama Hari Cuti" value="{{ $cuti->lama_cuti }}">
                                @error ('lama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label>Tanggal Awal Cuti</label>
                                <input type="date" class="form-control" name="tgl_mulai" value="{{ $cuti->tgl_mulai }}">
                                @error ('tgl_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label>Tanggal Akhir Cuti</label>
                                <input type="date" class="form-control" name="tgl_akhir" value="{{ $cuti->tgl_akhir }}">
                                @error ('tgl_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>
                                Sedang menyimpan
                            </div>
                            <div class="hide-text">
                                <i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Update Cuti
                            </div>
                        </button>
                    </form>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>

    </div><!-- container -->
</div>
</div><!-- content -->

<script type="text/javascript">

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });



    (function () {
        $('.needs-validation').on('submit', function () {
            $('.btn-success').attr('disabled', 'true');
            $('.spinner').show();
            $('.hide-text').hide();
        })
    })();


</script>
@endsection
