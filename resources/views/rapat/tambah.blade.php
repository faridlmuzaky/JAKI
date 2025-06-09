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
              <li class="breadcrumb-item active" aria-current="page">Rapat Pengadilan Tinggi Agama Bandung</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Tambah Rapat</h4>
        </div>
        <div class="d-flex justify-content-end">
      
          <a href="{{url('/rapat')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Kembali</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Tambah Rapat</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Menambahkan Jadwal Rapat</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="{{ url('/saverapat') }}" class="needs-validation" enctype="multipart/form-data">
              
              @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Judul Rapat</label>
                    <input type="text" name="judul" class="form-control" value="{{old('judul')}}" autofocus>
                    {{-- <input type="text" name="nip" class="form-control" value="{{$cuti[0]->nip}}" readonly value="{{old('nip')}}"> --}}
                    @error ('judul')  
                    {{$message }}
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                    {{-- <input type="hidden" name="id_cuti" value="{{$cuti[0]->id}}"> --}}
                  </div>
                  <div class="form-group col-md-6 ">
                    <label>Jenis Rapat</label>
                    <select class="custom-select @error ('jenis') is-invalid @enderror" name="jenis">
                      <option value ="" selected >- Pilih Jenis Kegiatan -</option>
                      <option value="RP" {{collect(old('jenis'))->contains('RP') ? 'selected':''}}>Rapat Pembinaan</option>
                      <option value="RK" {{collect(old('jenis'))->contains('RK') ? 'selected':''}}>Rapat Koordinasi</option>
                      <option value="RM" {{collect(old('jenis'))->contains('RM') ? 'selected':''}}>Rapat Monev</option>
                      <option value="RL" {{collect(old('jenis'))->contains('RL') ? 'selected':''}}>Rapat Lainnya</option>
                    </select>
                    @error ('jenis')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                 
                </div>
               
                
                {{-- </div> --}}
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label>Tanggal Rapat</label>
                    <input type="date" class="form-control @error ('tgl_rapat') is-invalid @enderror" name="tgl_rapat" id="tgl_rapat"  placeholder=""  value="{{old('tgl_rapat')}}">
                    @error ('tgl_rapat')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label>Waktu Awal Rapat</label>
                    <input type="time" class="form-control @error ('waktu') is-invalid @enderror" name="waktu" id="waktu"  placeholder="" :value="old('waktu')"  value="{{old('waktu')}}">
                    @error ('waktu')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label>Tempat Rapat</label>
                    <input type="text" class="form-control @error ('tempat') is-invalid @enderror" name="tempat" id="tempat"  placeholder="" :value="old('tempat')"  value="{{old('tempat')}}">
                    @error ('tempat')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                </div>     

                <div class="form-row">
                    <div class="form-group col-md-4 ">
                        <label>Pimpinan Rapat</label>
                        <select class="custom-select @error ('pimpinan') is-invalid @enderror" name="pimpinan">
                          <option value ="" >- Pilih Pimpinan Rapat -</option>
                            @foreach ($pimpinan as $pimpinan)
                                <option value="{{$pimpinan->name}}" {{ (collect(old('pimpinan'))->contains($pimpinan->name)) ? 'selected':'' }}>{{$pimpinan->name ." - ". $pimpinan->jabatan }}</option>
                            @endforeach
            
                        </select>
                        @error ('pimpinan')  
                          <div class="invalid-feedback">  
                          {{$message }}
                          </div> 
                        @enderror
                    </div>

                    <div class="form-group col-md-4 ">
                        <label>Notulis</label>
                        <select class="custom-select @error ('notulis') is-invalid @enderror" name="notulis">
                          <option value ="" selected >- Pilih Notulis -</option>
                          @foreach ($notulis as $user)
                            <option value="{{$user->name}}" {{ (collect(old('notulis'))->contains($user->name)) ? 'selected':'' }}>{{$user->name ." - ". $user->jabatan }}</option>
                            @endforeach
                        </select>
                        @error ('notulis')  
                          <div class="invalid-feedback">  
                          {{$message }}
                          </div> 
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                    <label>Link Foto (Google drive)</label>
                    <input type="text" class="form-control @error ('foto') is-invalid @enderror" name="foto" id="foto"  placeholder="" :value="old('foto')"  value="{{old('foto')}}">
                    @error ('foto')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>

		    <div class="form-group col-md-4">
                        <label>
                            Pakaian (Opsional)
                            <input type="checkbox" id="pakaian-check" name="pakaian_check">
                        </label>
                        <input type="text" class="form-control" name="pakaian" id="pakaian" placeholder="" :value="old('pakaian')" value="{{old('pakaian')}}" disabled>
                    </div>
                    <div class="form-group col-md-8"></div>

                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h6 class="mg-b-5">Pilih Peserta Rapat</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Pegawai yang menjadi peserta rapat</p>
                      </div><!-- card-header -->

                    <div class="table-responsive">
                        <div class="card-body pd-20">
                          <table class="table mt-3" id="tabel1">
                              <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">NIP/NIK</th>
                                      <th scope="col">Nama</th>
                                      <th scope="col">Jabatan</th>
                                      <th scope="col"><input type="checkbox" name="chk[]" onchange="checkAll(this)"></th>
                                  </tr>
                              </thead>
                              @foreach ($notulis as $item)   
                              <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>
                                      {{$item->username}}</>
                                  </td>
                                  <td>{{$item->name}}</td>
                                  <td>{{$item->jabatan}}</td> 
                                  <td>
                                      <input type="checkbox" name="chk[]" value="{{$item->username}}" />
                                  </td>
                              </tr>
                          @endforeach
                             
                          </table>
 
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
    function checkAll(ele) {
         var checkboxes = document.getElementsByTagName('input');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox' ) {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }
   </script>
<script type="text/javascript">
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

<script>
    $('#pakaian-check').change(function() {
        if (this.checked) {
            $("#pakaian").attr("disabled", false);
        } else {
            $("#pakaian").val("");
            $("#pakaian").attr("disabled", true);
        }
    });
</script>
@endsection