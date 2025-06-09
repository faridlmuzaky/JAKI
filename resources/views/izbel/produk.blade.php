@extends('layout.main')
@section('title', 'Unggah Surat Izin Belajar')

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
          <h4 class="mg-b-0 tx-spacing--1">Surat Izin Belajar</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/prosesizbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-5 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Kirim Surat Izin Belajar</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Kirim Surat Izin Belajar Untuk Satker</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="/izbel/{{$izbel->id}}/produkupdate" class="needs-validation" enctype="multipart/form-data">
              @csrf
                

                @if ($izbel->status_kunci =='0' || $izbel->status_kunci !='1' )
                    <input type="hidden" value="0" name="isi">
                    <button type="submit" class="btn btn-success"><i data-feather="lock" class="wd-20 mg-r-5"></i>Kunci Permohonan</button>
                  {{-- {{dd($izbel->all())}}   --}}
                 
                @endif
                @if ($izbel->status_kunci =='1')
                  <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" :value="old('file')" >
                    <label class="custom-file-label" for="customFile">{{$izbel->produk}}</label>
                    @error ('file7')  
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{$errors->first('file7')  }}
                        </div>
                    @enderror
                  </div>
                @endif
                <button type="submit" class="btn btn-success"><i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Kirimkan Izin Belajar</button>
              </form>
                
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
        <!-- Button trigger modal -->
    </div><!-- container -->
  </div>
</div><!-- content -->  


  
  
<!-- Cetak Modal -->
<div class="modal fade" id="cetakModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cetak Surat Permohonan/Keputusan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="/izbel/{{$izbel->id}}/cetak" class="needs-validation" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 col-form-label">No Surat</label>
                  <div class="col-sm-9">
                    <input name="nosurat" type="text" class="form-control" id="inputEmail3" placeholder="Nomor Surat">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 col-form-label">Tanggal Surat</label>
                  <div class="col-sm-9">
                    <input name="tglsurat" type="date" class="form-control" id="inputPassword3" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Tujuan</label>
                    <div class="col-sm-9">
                        <select class="custom-select" name="tujuan">
                            <option selected disabled>- Pilih -</option>
                            <option value="1">Badan Urusan Administrasi</option>
                            <option value="2">Badilag</option>
                            <option value="3">Satker Pemohon</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Cetak</button>
            </div>
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>
@endsection