@extends('layout.main')
@section('title', 'Approval Cuti Ketua')

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
              <li class="breadcrumb-item active" aria-current="page">Persetujuan Ketua/PPK Usul Cuti</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Persetujuan Ketua/PPK Usul Cuti</h4>
        </div>
        <div class="d-flex justify-content-end">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/approvalcutippk')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
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
              <form method="POST" action="/approvalcutippkdetail/{{$cuti->id_detail}}/proses" class="needs-validation" enctype="multipart/form-data">
                
                @csrf
                <input type="hidden" value="{{$cuti->lama_cuti}}" name="lama_cuti">
                <input type="hidden" value="{{$cuti->id}}" name="id_master">
                <input type="hidden" value="{{$cuti->jenis_cuti}}" name="jenis_cuti">
                <input type="hidden" name="nip" value="{{$cuti->nip}}">
                <input type="hidden" name="nama" value="{{$cuti->nama}}">
                <input type="hidden" name="pejabat_berwenang" value="{{$cuti->pejabat_berwenang}}">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-muted">{{$cuti->nama}}</span>
                  <span class="badge badge-success">{{$cuti->nip}}</span>
                </h4>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Jabatan</h6>
                      <medium class="text-muted">{{$cuti->jabatan}}</medium>
                      
                    </div>
                    {{-- <span class="text-muted">$12</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Satuan Kerja</h6>
                      <medium class="text-muted">{{$cuti->satker}}</medium>
                    </div>
                    {{-- <span class="text-muted">$8</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Jenis Cuti</h6>
                      <medium class="text-muted">{{$cuti->jenis_cuti}}</medium>
                    </div>
                    {{-- <span class="text-muted">$8</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Alasan Cuti</h6>
                      <medium class="text-muted">{{$cuti->alasan_cuti}}</medium>
                    </div>
                    {{-- <span class="text-muted">$8</span> --}}
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Lama Cuti</h6>
                      <medium class="text-muted">{{$cuti->lama_cuti}} hari</medium>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Tanggal Cuti</h6>
                      <medium class="text-muted">{{ date('d M Y',strtotime($cuti->tgl_mulai))}} s.d {{date('d M Y',strtotime($cuti->tgl_akhir))}}</medium>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Alamat Cuti</h6>
                      <medium class="text-muted">{{ $cuti->alamat_cuti}}</medium>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">Dokumen Pendukung (Surat Sakit dll)</h6>
                        @if ($cuti->dok_cuti)
                            <medium class="text-muted"><a href="{{asset('images').'/'.$cuti->dok_cuti}}">Download File</a></medium>
                        @else
                            <medium class="text-muted">Tidak ada File</medium>
                        @endif
                    </div>
                  </li>
                  
         
                </ul>

                <ul class="list-group mb-3">
                    <li class="list-group-item justify-content-between ">
                        <div>Permohonan</div>  
                   
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hasil" id="inlineRadio1" value="Disetujui" checked>
                            <label class="form-check-label" for="inlineRadio1">Disetujui</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hasil" id="inlineRadio2" value="Perubahan">
                            <label class="form-check-label" for="inlineRadio2">Perubahan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hasil" id="inlineRadio2" value="Ditangguhkan">
                            <label class="form-check-label" for="inlineRadio2">Ditangguhkan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hasil" id="inlineRadio2" value="Tidak Disetujui">
                            <label class="form-check-label" for="inlineRadio2">Tidak Disetujui</label>
                        </div>
                        <hr>
                        <div>Keterangan</div>
                        <div>
                            <textarea class="form-control" rows="2" placeholder="Textarea" name="keterangan"></textarea>
                        </div>

                    </li>
                    
                    <li class="list-group-item d-flex justify-content-between ">
                      <button type="submit" class="btn btn-primary">
                        <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>Sedang menyimpan</div>
                        <div class="hide-text">
                          <i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Simpan
                        </div>
                      </button>
                    </li>
                </ul>
              </form>
            </div>
            
            <div class="col-md- col-lg-5 order-md-last">
                

                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Informasi Cuti</span>
                        {{-- <span class="badge badge-success">{{$izbel->nip}}</span> --}}
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Jenis Cuti</h6>
                            <medium class="text-muted"></medium>
                        </div>

                            <span class="my-0"><h6 class="my-0">Sisa Cuti</h6></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-2</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t2}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-1</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t1}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Tahunan N-0</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_tahun_t0}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Sakit</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cs}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Alasan Penting</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cap}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Besar</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cbesar}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Diluar Tanggungan Negara</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cltn}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Cuti Melahirkan</a></h6>
                            </div>
                            <span class="">
                                    {{$cuti->sisa_cm}}
                            </span>
                        </li>
                        
                       
                        
                       
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

    (function () {
            $('.needs-validation').on('submit', function () {
                $('.btn-primary').attr('disabled', 'true');
                $('.spinner').show();
                $('.hide-text').hide();
            })
        })();

</script>

@endsection