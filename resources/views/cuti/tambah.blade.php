@extends('layout.main')
@section('title', 'Cuti Ketua Pengadilan Agama')

@section('content')
<div class="content-body">
     {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Cuti Ketua Pengadilan</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Permohonan Cuti</h4>
        </div>
        <div class="d-flex justify-content-end">
      
          <a href="{{url('/cuti')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Tambah Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Menambahkan permohonan cuti</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="{{ url('/savecuti') }}" class="needs-validation" enctype="multipart/form-data">
              
              @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{$cuti[0]->nip}}" readonly value="{{old('nip')}}">
                    @error ('nip')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                    <input type="hidden" name="id_cuti" value="{{$cuti[0]->id}}">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Nama</label>
                    <input type="text" name="nama" readonly class="form-control @error ('nama') is-invalid @enderror" id="inputPassword4" :value="old('nama')" placeholder="Nama Pegawai"  value="{{$cuti[0]->nama}}" >
                    @error ('nama')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>
                </div>
                <div class = "form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Jabatan</label>
                        <input type="text" name="jabatan" readonly class="form-control" id="inputPassword4" value="{{$cuti[0]->jabatan}}" >
                          @error ('jabatan')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                          @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Satuan Kerja</label>
                        <input type="text" name="satker" readonly class="form-control" placeholder="Nama Pegawai"  value="{{$cuti[0]->nama_satker}}" >
                    </div>
             
                </div> 
                
                  <div class="form-row">
                    <div class="form-group col-md-6 ">
                      <label>Jenis Cuti</label>
                      <select class="custom-select @error ('jenis') is-invalid @enderror" name="jenis">
                        <option value ="" selected >- Pilih Jenis Cuti -</option>
                        <option value="CT">Cuti Tahunan</option>
                        <option value="CB">Cuti Besar</option>
                        <option value="CS">Cuti Sakit</option>
                        <option value="CM">Cuti Bersalin</option>
                        <option value="CAP">Cuti Alasan Penting</option>
                        <option value="CLTN">CTLN</option>
                      </select>
                      @error ('jenis')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                      @enderror
                    </div>
                    <div class="form-group col-md-6 ">
                      <label>Alasan Cuti</label>
                      <input type="text" class="form-control @error ('alasan') is-invalid @enderror" name="alasan" id="alasan" placeholder="Alasan Cuti" :value="old('alasan')"  value="{{old('alasan')}}">
                      @error ('alasan')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                      @enderror
                    </div>
                  </div>
                  <div class="form-group ">
                    <label>Alamat Cuti</label>
                    {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                    <textarea class="form-control @error ('alamatcuti') is-invalid @enderror" id="exampleFormControlTextarea1" name="alamatcuti" rows="3" value="{{old('alamatcuti')}}">{{old('alamatcuti')}}</textarea>
                    @error ('alamatcuti')  
                        <div class="invalid-feedback">  
                          {{$message }}
                        </div> 
                    @enderror
                  </div>
                 
                {{-- </div> --}}
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label>Lama Cuti</label>
                    <input type="text" class="form-control @error ('lama') is-invalid @enderror" name="lama" id="lama" placeholder="Lama Hari Cuti" :value="old('lama')"  value="{{old('lama')}}">
                    @error ('lama')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-5">
                    <label>Tanggal Awal Cuti</label>
                    <input type="date" class="form-control @error ('tgl_awal') is-invalid @enderror" name="tgl_awal" id="tgl_awal"  placeholder="" :value="old('tgl_awal')"  value="{{old('tgl_awal')}}">
                    @error ('tgl_awal')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-5">
                    <label>Tanggal Akhir Cuti</label>
                    <input type="date" class="form-control @error ('tgl_akhir') is-invalid @enderror" name="tgl_akhir" id="tgl_akhir" placeholder="" :value="old('tgl_akhir')"  value="{{old('tgl_akhir')}}">
                    @error ('tgl_akhir')  
                      <div class="invalid-feedback">  
                        {{$message }}
                      </div> 
                    @enderror
                  </div>
                </div>     
                <div class="form-row">
                  <div class="form-group col-md-6 ">
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Catatan Cuti</b>
                        {{-- <span class="badge badge-primary badge-pill">Sisa</span> --}}
                        <span><b>Sisa</b></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Tahunan N-2
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_tahun_t2}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Tahunan N-1
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_tahun_t1}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Tahunan N-0
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_tahun_t0}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Besar
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_cbesar}}</span>
                      </li>
                    </ul>

                  </div>
                  <div class="form-group col-md-6 ">
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Catatan Cuti</b>
                        {{-- <span class="badge badge-primary badge-pill">Sisa</span> --}}
                        <span><b>Sisa</b></span>
                      </li>
                    
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Sakit
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_cs}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Melahirkan
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_cm}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Karena Alasan Penting
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_cap}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cuti Diluar Tanggungan Negara
                        <span class="badge badge-primary badge-pill">{{$cuti[0]->sisa_cltn}}</span>
                      </li>
                    </ul>

                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6 ">
                    <label for="inputPassword3" >Dokumen pendukung (Contoh : Surat keterangan sakit dari dokter)</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" :value="old('file')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file')  }}
                              </div>
                          @enderror
                        </div>
                  </div>
                  <div class="form-group col-md-6 ">
                    <label>Nomor Telepon/HP (Contoh : 08xxxxxxx)</label>
                      <input type="text" class="form-control @error ('nohp') is-invalid @enderror" name="nohp" id="inputPassword4" placeholder="Nomor Telepon/HP" :value="old('nohp')"  value="{{old('nohp')}}">
                      @error ('nohp')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                      @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6 ">
                    <label>Atasan Langsung</label>
                    <select class="custom-select @error ('atasan_langsung') is-invalid @enderror" name="atasan_langsung">
                      <option value="" selected>- Silahkan Pilih -</option>
                      @foreach ($user as $user)
                      <option value="{{$user->username}}">{{$user->name ." - ". $user->jabatan }}</option>
                      @endforeach
                      
                    </select>
                    @error ('atasan_langsung')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>
                  
                  <div class="form-group col-md-6 ">
                    <label>Pejabat Yang Berwenang Memberikan Cuti</label>
                    <select class="custom-select @error ('ppk') is-invalid @enderror" name="ppk">
                      <option value="" selected>- Silahkan Pilih -</option>
                      @foreach ($user2 as $user2)
                      <option value="{{$user2->username}}">{{$user2->name ." - ".   $user2->jabatan }}</option>
                      @endforeach
                      
                    </select>
                    @error ('ppk')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>

                       
                </div>
                          
                  <button type="submit" class="btn btn-success"><i data-feather="upload-cloud" class="wd-20 mg-r-5"></i>Kirimkan Permohonan</button>
            </form>
            
          </div><!-- card-body -->
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