@extends('layout.main')
@section('title', 'Proses Cuti')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Proses Cuti</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Proses Permohonan Cuti</h4>
        </div>
        <div class="d-flex justify-content-end">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/prosesizbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Proses Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Proses permohonan Cuti</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            {{-- @foreach ($izbel as $item) --}}
                
            {{-- @endforeach --}}
        <div class="row">
            <div class="col-md- col-lg-7 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                  {{-- <span class="text-muted">{{$izbel->nama_pegawai}}</span> --}}
                  {{-- <span class="badge badge-success">{{$izbel->nip}}</span> --}}
                </h4>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Jabatan</h6>
                      {{-- <medium class="text-muted">{{$izbel->jabatan}}</medium> --}}
                    </div>
                    {{-- <span class="text-muted">$12</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Golongan</h6>
                      {{-- <medium class="text-muted">{{$izbel->golongan}}</medium> --}}
                    </div>
                    {{-- <span class="text-muted">$8</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Izin Pedidikan</h6>
                      {{-- <medium class="text-muted">{{$izbel->izin_pendidikan}}</medium> --}}
                    </div>
                    {{-- <span class="text-muted">$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Nama Universitas</h6>
                      {{-- <medium>{{$izbel->nama_universitas}}</medium> --}}
                    </div>
                    {{-- <span class="text-success">−$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Alamat Universitas</h6>
                      {{-- <medium>{{$izbel->alamat_universitas}}</medium> --}}
                    </div>
                    {{-- <span class="text-success">−$5</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between ">
                    <div class="text-muted">
                      <h6 class="my-0">Program Studi</h6>
                      {{-- <medium>{{$izbel->program_studi}}</medium> --}}
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
                    <form method="POST" action="" class="needs-validation" enctype="multipart/form-data">
                    {{-- <form method="POST" action="/izbel/{{$izbel->id}}/saveproses" class="needs-validation" enctype="multipart/form-data"> --}}
                        @csrf

                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Kelengkapan Dokumen</span>
                            {{-- <span class="badge badge-success">{{$izbel->nip}}</span> --}}
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Persyaratan</h6>
                                <medium class="text-muted"></medium>
                            </div>

                                <span class="text-muted">Memenuhi  
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_surat_pengantar}}">Surat Pengantar</a></h6> --}}
                                <medium class="text-muted"></medium>
                            </div>

                                <span class="text-muted">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="SuratPengantar" name="SuratPengantar" value="1">
                                        <label class="custom-control-label" for="SuratPengantar"></label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_sk_pns}}">SK PNS</a></h6> --}}
                                <medium class="text-muted"></medium>
                            </div>
                                <span class="text-muted">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="SKPns" name="SKPns" value="1">
                                        <label class="custom-control-label" for="SKPns"></label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_s_universitas}}">Keterangan Sebagai Mahasiswa</a></h6> --}}
                            
                            </div>
                                <span class="text-muted">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="SuratKeterangan" name="SuratKeterangan">
                                        <label class="custom-control-label" for="SuratKeterangan"></label>
                                    </div>
                                </span>NO	URAIAN TUGAS	INDEKS BEBAN KERJA	BIDANG 	PIC	PIC BARU
                                1	ABSENSI HARIAN PEGAWAI PTA	5	ASDM	MURSYID	SABRINA
                                3	MENGISI ABSENSI KOMDANAS	5	ASDM	MURSYID	SABRINA
                                5	CUTI PEGAWAI PTA	5	ASDM	MURSYID	SABRINA
                                7	KGB PEGAWAI PTA	5	ASDM	MURSYID	MEILA
                                9	KNP KESEKRETARIATAN	5	ASDM	MURSYID	MEILA
                                11	BAHAN BAPERJAKAT	4	ASDM	MURSYID	MEILA
                                14	PENYESUAIAN IJAZAH	3	ASDM	MURSYID	MEILA
                                15	IZIN BELAJAR	3	ASDM	MURSYID	MEILA
                                16	PENCANTUMAN GELAR	4	ASDM	MURSYID	MEILA
                                18	USULAN TANDA JASA /SATYA LANCANA	2	ASDM	MURSYID	MEILA
                                19	SURAT TUGAS/SPD	5	ASDM	MURSYID	SABRINA
                                21	KARIS/KARSU/KARPEG/TASPEN/BPJS	5	ASDM	MURSYID	MEILA
                                34	ANJAB	4	ORTALA	MURSYID	SABRINA
                                
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                            <div class="text-muted">
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_akreditasi}}">Sertifikat Akreditasi</a></h6> --}}
                                {{-- <medium>{{$izbel->nama_universitas}}</medium> --}}
                            </div>
                                <span class="text-muted">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="SertfikatAkreditasi" name="SertfikatAkreditasi">
                                        <label class="custom-control-label" for="SertfikatAkreditasi"></label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                            <div class="text-muted">
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_pernyataan}}">Pernyataan Tidak Menggangu Jam Kerja</a></h6> --}}
                        
                            </div>
                                <span class="text-muted">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Pernyataan" name="Pernyataan">
                                        <label class="custom-control-label" for="Pernyataan"></label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                            <div class="text-muted">
                                {{-- <h6 class="my-0"><a href="{{asset('images').'/'.$izbel->file_rekomendasi}}">Rekomendasi Ketua Pengadilan</a></h6> --}}
                                {{-- <medium>{{$izbel->program_studi}}</medium> --}}
                            </div>
                            <span class="text-muted">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="Rekomendasi" name="Rekomendasi">
                                    <label class="custom-control-label" for="Rekomendasi"></label>
                                </div>
                            </span>
                            </li>
                            {{-- <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$20</strong>
                            </li> --}}
                        </ul>
                        <ul class="list-group mb-3">
                            <li class="list-group-item justify-content-between ">
                                <div>Permohonan</div>  
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hasil" id="inlineRadio1" value="Diterima" checked>
                                    <label class="form-check-label" for="inlineRadio1">Terima</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hasil" id="inlineRadio2" value="Ditolak">
                                    <label class="form-check-label" for="inlineRadio2">Tolak</label>
                                </div>
                                <hr>
                                <div>Alasan ditolak</div>
                                <div>
                                    <textarea class="form-control" rows="2" placeholder="Textarea" name="alasan"></textarea>
                                </div>

                            </li>
                            <li class="list-group-item d-flex justify-content-between ">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </li>
                        </ul>
                    </form>
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