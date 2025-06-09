@extends('layout.main')
@section('title', 'Tambah Mutasi Detail')

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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Mutasi Detail</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Data Mutasi Detail</h4>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{url('/mutasi/'.$jenis.'/'.$data->id.'/detail')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                        <i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
                </div>
            </div>

            {{-- Main Content  --}}
            <div class="col-lg-4 col-xl-12 mg-t-10">
                <div class="card">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h6 class="mg-b-5">Tambah Detail Mutasi</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Menambahkan Detail Mutasi</p>

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
                        <form method="POST" action="{{ url('/savemutasidetail') }}" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $jenis }}" name="jenis">
                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label for="jenis_mutasi">Periode Mutasi</label>
                                    <input type="text" class="form-control" value="{{ $data->periode }}" readonly>
                                    <input type="hidden" value="{{ $data->id }}" name="id_mutasi">
                                </div>
                            </div>
                            <hr>
                            <div class = "form-row">
                                <div class="form-group col-md-6">
                                    <label for="jenis_mutasi">SK Baperjakat</label>
                                    <input type="file" class="form-control" name="sk_baperjakat" accept="application/pdf">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jenis_mutasi">Lampiran SK</label>
                                    <input type="file" class="form-control" name="lampiran_sk" accept="application/pdf">
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
