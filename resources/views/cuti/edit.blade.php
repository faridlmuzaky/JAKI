@extends('layout.main')
@section('title', 'Cuti Ketua Pengadilan Agama')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Cuti Pegawai Pengadilan</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Master Cuti Tahunan</h4>
        </div>
        {{-- <div class="d-none d-md-block"> --}}
        <div class="d-flex justify-content-end">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/mastercuti')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Ubah Master Cuti Tahunan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Ubah Saldo Awal Cuti Tahunan</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="/mastercuti/{{$cuti->id}}/update" class="needs-validation" enctype="multipart/form-data">
              
              @csrf
                
                
                  <div class="form-row">
                        <input type="hidden" name="nip" value="{{$cuti->nip}}">
                      <div class="form-group col-md-6">
                        <label>Tahun Anggaran</label>
                        
                        <input type="number" class="form-control @error ('tahun_anggaran') is-invalid @enderror" id="tahun_anggaran" name="tahun_anggaran" placeholder="" value="{{$cuti->tahun_anggaran}}"  disabled>
                        @error ('tahun_anggaran')  
                          <div class="invalid-feedback">  
                          {{$message }}
                          </div> 
                        @enderror
                      </div>
                      <div class="form-group col-md-6">
                        <label>Cuti 2 Tahun Lalu (N-2) ( <?= now()->year - 2 ?> )</label>
                        <input type="number" name="cuti_2tahun_lalu" class="form-control @error ('cuti_2tahun_lalu') is-invalid @enderror" id="cuti_2tahun_lalu" value="{{$cuti->sisa_tahun_t2}}" placeholder="sisa cuti 2 tahun lalu  N-2"  >
                        @error ('cuti_2tahun_lalu')  
                              <div class="invalid-feedback">  
                              {{$message }}
                              </div> 
                        @enderror
                      </div>
                 
                  </div>
                  <div class="form-row">
                    
                    <div class="form-group col-md-6">
                      <label>Cuti Tahun Lalu (N-1) ( <?= now()->year - 1 ?> )</label>
                      <input type="number" name="cuti_tahun_lalu" class="form-control @error ('cuti_tahun_lalu') is-invalid @enderror" id="cuti_tahun_lalu" value="{{$cuti->sisa_tahun_t1}}" placeholder="sisa cuti tahun lalu N-1"  >
                      @error ('cuti_tahun_lalu')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Cuti Tahun Ini ( <?= now()->year?> )</label>
                        <input type="number" name="cuti_tahun_ini" class="form-control @error ('cuti_tahun_ini') is-invalid @enderror" id="cuti_tahun_ini" value="{{$cuti->sisa_tahun_t0}}" placeholder="cuti tahun ini"  >
                        @error ('cuti_tahun_ini')  
                              <div class="invalid-feedback">  
                              {{$message }}
                              </div> 
                        @enderror
                      </div>
                 </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Cuti Sakit</label>
                      <input type="number" name="cuti_sakit" class="form-control @error ('cuti_sakit') is-invalid @enderror" id="cuti_sakit" value="{{$cuti->sisa_cs}}" placeholder="cuti sakit "  >
                      @error ('cuti_sakit')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Cuti Alasan Penting</label>
                        <input type="number" name="cap" class="form-control @error ('cuti_2tahun_lalu') is-invalid @enderror" id="cap" value="{{$cuti->sisa_cap}}" placeholder="cuti alasan penting"  >
                        @error ('cap')  
                              <div class="invalid-feedback">  
                              {{$message }}
                              </div> 
                        @enderror
                      </div>
                 </div>
                {{-- </div> --}}

                <div class="form-row">
                
                </div>
           
               
                
                  <button type="submit" class="btn btn-success"><i data-feather="save" class="wd-20 mg-r-5"></i>Simpan</button>
              </form>
            
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
</div><!-- content -->  

<script type="text/javascript">
  var delay = (function () {
      var timer = 0;
      return function (callback, ms) {
          clearTimeout(timer);
          timer = setTimeout(callback, ms);
      };
  })();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  // $('.custom-file-input').on('change', function() {
  //     let fileName = $(this).val().split('\\').pop();
  //     $(this).next('.custom-file-label').addClass("selected").html(fileName);
  // });


  $("#btnCari").on('click',function () {
      delay(function () {
          var nip = $("#nip").val();

          $.ajax({
              type :'GET',
              url: "{{ url('/caripegawai') }}",
              data:"nip="+nip,
              success:function(data){
                        var json = data,
                      obj = JSON.parse(json);
                      if (Object.keys(obj).length === 0){
                          $('#hnip').val(null);
                          $('#nama').val(null);
                          $('#jabatan').val(null);
                          $('.nipp').addClass('is-invalid');
                          $('.invalid-feedback').remove();
                          $('.nipp').after("<div id='validationServer03Feedback' class='invalid-feedback'> {{('NIP tidak ditemukan')}}</div>");
                          
                      }else{
                          $('.nipp').removeClass('is-invalid');
                          $('#hnip').val(obj.nip);
                          $('#nama').val(obj.nama);
                          $('#jabatan').val(obj.jabatan);
                          $('#satker').val(obj.satker);
                          $('#id_satker').val(obj.id_satker);
                          $('.invalid-feedback').remove();
                      }
              },
              error: function(data){
                  $('#nama').val('tidak ada pegawai');
                  $('#jabatan').val('tidak ada pegawai');
                  $('#satker').val('tidak ada pegawai');
                  // $('#nama').val(obj.nip);

              }
          });
      }, 1);
  });
</script>
@endsection