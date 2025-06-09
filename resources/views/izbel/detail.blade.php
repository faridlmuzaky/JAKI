@extends('layout.main')
@section('title', 'User Management')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Izin Belajar</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Permohonan Izin Belajar</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/izbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Detail Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Detail permohonan izin belajar</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            {{-- @foreach ($izbel as $item) --}}
                
            {{-- @endforeach --}}
        <div class="row">
            <div class="col-md- col-lg-7 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-muted">{{$izbel->nama_pegawai}}</span>
                  <span class="badge badge-success">{{$izbel->nip}}</span>
                </h4>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Jabatan</h6>
                      <medium class="text-muted">{{$izbel->jabatan}}</medium>
                    </div>
                    {{-- <span class="text-muted">$12</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Golongan</h6>
                      <medium class="text-muted">{{$izbel->golongan}}</medium>
                    </div>
                    {{-- <span class="text-muted">$8</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Izin Pedidikan</h6>
                      <medium class="text-muted">{{$izbel->izin_pendidikan}}</medium>
                    </div>
                    {{-- <span class="text-muted">$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Nama Universitas</h6>
                      <medium>{{$izbel->nama_universitas}}</medium>
                    </div>
                    {{-- <span class="text-success">−$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Alamat Universitas</h6>
                      <medium>{{$izbel->alamat_universitas}}</medium>
                    </div>
                    {{-- <span class="text-success">−$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Program Studi</h6>
                      <medium>{{$izbel->program_studi}}</medium>
                    </div>
                    {{-- <span class="text-success">−$5</span> --}}
                  </li>
                  {{-- <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$20</strong>
                  </li> --}}
                </ul>
            </div>
            <div class="col-md- col-lg-5 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Kelengkapan Dokumen</span>
                    {{-- <span class="badge badge-success">{{$izbel->nip}}</span> --}}
                  </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                      <div>
                        <h6 class="my-0">Surat Pengantar</h6>
                        <medium class="text-muted"></medium>
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_surat_pengantar}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                      <div>
                        <h6 class="my-0">SK PNS</h6>
                        <medium class="text-muted"></medium>
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_sk_pns}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                      <div>
                        <h6 class="my-0">Keterangan Sebagai Mahasiswa</h6>
                        {{-- <medium class="text-muted">{{$izbel->izin_pendidikan}}</medium> --}}
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_s_universitas}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between ">
                      <div class="text-muted">
                        <h6 class="my-0">Sertifikat Akreditasi</h6>
                        {{-- <medium>{{$izbel->nama_universitas}}</medium> --}}
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_akreditasi}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between ">
                      <div class="text-muted">
                        <h6 class="my-0">Pernyataan Tidak Menggangu Jam Kerja</h6>
                        {{-- <medium>{{$izbel->alamat_universitas}}</medium> --}}
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_pernyataan}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between ">
                      <div class="text-muted">
                        <h6 class="my-0">Rekomendasi Ketua Pengadilan</h6>
                        {{-- <medium>{{$izbel->program_studi}}</medium> --}}
                      </div>
                      <span class="text-muted"><a href="{{asset('images').'/'.$izbel->file_rekomendasi}}"><i data-feather="download-cloud" class="wd-20 mg-r-5"></i></a></span>
                    </li>
                    {{-- <li class="list-group-item d-flex justify-content-between">
                      <span>Total (USD)</span>
                      <strong>$20</strong>
                    </li> --}}
                  </ul>

            </div>
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
</div><!-- content -->  

<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>
@endsection