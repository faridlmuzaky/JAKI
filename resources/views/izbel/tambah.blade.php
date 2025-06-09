@extends('layout.main')
@section('title', 'Izin Belajar')

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
            <h6 class="mg-b-5">Tambah Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Menambahkan permohonan izin belajar</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="{{ url('/izbel') }}" class="needs-validation" enctype="multipart/form-data">
              @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">NIP</label>
                    <input type="text" name="nip" class="form-control @error ('nip') is-invalid @enderror" id="nip" :value="old('nip')" id="inputEmail4" placeholder="NIP"  value="{{old('nip')}}">
                    @error ('nip')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Nama</label>
                    <input type="text" name="nama" class="form-control @error ('nama') is-invalid @enderror" id="inputPassword4" :value="old('nama')" placeholder="Nama Pegawai"  value="{{old('nama')}}">
                    @error ('nama')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>
                </div>
                <div class = "form-row">
                    <div class="form-group col-md-5">
                        <label for="inputAddress">Jabatan</label>
                        <select class="custom-select @error ('jabatan') is-invalid @enderror" name="jabatan" id="pendidikan">
                            <option value="" disabled selected>- Pilih -</option>
                            <option value="Ketua">Ketua</option>
                            <option value="Wakil Ketua">Wakil Ketua</option>
                            <option value="Hakim">Hakim</option>
                            <option value="Panitera">Panitera</option>
                            <option value="Sekretaris">Sekretaris</option>
                            <optgroup label="Kepaniteraan">
                              <option value="Panitera Muda Hukum">Panitera Muda Banding</option>
                              <option value="Panitera Muda Hukum">Panitera Muda Hukum</option>
                              <option value="Panitera Muda Gugatan">Panitera Muda Gugatan</option>
                              <option value="Panitera Muda Permohonan">Panitera Muda Permohonan</option>
                              <option value="Panitera Pengganti">Panitera Pengganti</option>
                              <option value="Jurusita">Jurusita</option>
                              <option value="Jurusita Pengganti">Jurusita Pengganti</option>
                            </optgroup>
                            <optgroup label="Kesekretariatan">
                              <option value="Kepala Bagian Umum dan Keuangan">Kepala Bagian Umum dan Keuangan</option>
                              <option value="Kepala Bagian Perencanaan dan Kepegawaian">Kepala Bagian Perencanaan dan Kepegawaian</option>
                              <option value="Kasubbag Keuangan dan Pelaporan">Kasubbag Keuangan dan Pelaporan</option>
                              <option value="Kasubbag TU dan Rumah Tangga">Kasubbag TU dan Rumah Tangga</option>
                              <option value="Kasubbag Rencana Program dan Anggaran">Kasubbag Rencana Program dan Anggaran</option>
                              <option value="Kasubbag Kepegawaian dan TI">Kasubbag Kepegawaian dan TI</option>
                              <option value="Kasubbag Perencanaan, TI dan Pelaporan">Kasubbag Perencanaan, TI dan Pelaporan</option>
                              <option value="Kasubbag Umum dan Keuangan">Kasubbag Umum dan Keuangan</option>
                              <option value="Kasubbag Kepegawaian dan Ortala">Kasubbag Kepegawaian dan Ortala</option>
                            </optgroup>
                            <optgroup label="Pelaksana">
                              <option value="Analis Akuntabilitas Kinerja Aparatu">Analis Akuntabilitas Kinerja Aparatur</option>
                              <option value="Analis Perencanaan, Evaluasi dan Pelaporan">Analis Perencanaan, Evaluasi dan Pelaporan</option>
                              <option value="Pengelola Sistem dan Jaringan">Pengelola Sistem dan Jaringan</option>
                              <option value="Penyusun Laporan Keuangan">Penyusun Laporan Keuangan</option>
                              <option value="Pengadministrasi Persuratan">Pengadministrasi Persuratan</option>
                              <option value="Bendahara">Bendahara</option>
                              <option value="Pengelola Barang Milik Negara">Pengelola Barang Milik Negara</option>
                              <option value="Analis SDM Aparatur">Analis SDM Aparatur</option>
                              <option value="Pengelola Sistem Informasi Manajemen Kepegawaian">Pengelola Sistem Informasi Manajemen Kepegawaian</option>
                              <option value="Pengelola Kepegawaian">Pengelola Kepegawaian</option>
                              <option value="Pengadministrasi Hukum">Pengadministrasi Hukum</option>
                              <option value="Pengadministrasi Registrasi Perkara">Pengadministrasi Registrasi Perkara</option>
                              <option value="Pengelola Perkara">Pengelola Perkara</option>
                              <option value="Analis Perkara Peradila">Analis Perkara Peradilan</option>
                              <option value="Pengelola Keuangan">Pengelola Keuangan</option>
                              <option value="Pengolah Data Informasi dan Hukum">Pengolah Data Informasi dan Hukum</option>
                            </optgroup>
                            <optgroup label="Fungsional">
                              <option value="Analis Kepegawaian">Analis Kepegawaian</option>
                              <option value="Pranata Komputer">Pranata Komputer</option>
                              <option value="Arsiparis">Arsiparis</option>
                              <option value="Analis Pengelola Keuangan APBN">Analis Pengelola Keuangan APBN</option>
                              <option value="Pranata Keuangan APBN">Pranata Keuangan APBN</option>
                              <option value="Analis Perbendaharaan APBN">Analis Perbendaharaan APBN</option>
                            </optgroup>
                        </select>
                          @error ('jabatan')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                          @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress2">Golongan/Pangkat</label>
                        <select class="custom-select @error ('gol') is-invalid @enderror" name="gol" id="pendidikan">
                            <option value="" selected disabled>- Pilih -</option>
                            <option value="I/a">I/a</option>
                            <option value="I/b">I/b</option>
                            <option value="I/c">I/c</option>
                            <option value="I/d">I/d</option>
                            <option value="II/a">II/a</option>
                            <option value="II/b">II/b</option>
                            <option value="II/c">II/c</option>
                            <option value="II/d">II/d</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="III/c">III/c</option>
                            <option value="III/d">III/d</option>
                            <option value="IV/a">IV/a</option>
                            <option value="IV/b">IV/b</option>
                            <option value="IV/c">IV/c</option>
                            <option value="IV/d">IV/d</option>
                            <option value="IV/e">IV/e</option>
                        </select>
                          @error ('gol')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                          @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pendidikan">Izin Pendidikan</label>
                        <select class="custom-select @error ('izin_pendidikan') is-invalid @enderror" name="izin_pendidikan" id="pendidikan">
                          <option value="" disabled selected>-Pilih-</option>
                          <option value="S1">S1</option>
                          <option value="S2">S2</option>
                          <option value="S3">S3</option>
                        </select>
                          @error ('izin_pendidikan')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                          @enderror
                    </div>
                </div> 
                
                {{-- <div class="form-row"> --}}
                  <div class="form-group ">
                    <label>Nama Universitas</label>
                    <input type="text" class="form-control @error ('universitas') is-invalid @enderror" name="universitas" id="inputPassword4" placeholder="Nama Universitas" :value="old('universitas')"  value="{{old('universitas')}}">
                    @error ('universitas')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group ">
                    <label>Alamat Universitas</label>
                    <input type="text" class="form-control @error ('alamat') is-invalid @enderror" name="alamat" id="inputPassword4" placeholder="Alamat Universitas" :value="old('alamat')"  value="{{old('alamat')}}">
                    @error ('alamat')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                 
                {{-- </div> --}}
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>No Surat Keterangan Terdaftar Mahasiswa</label>
                    <input type="text" class="form-control @error ('surat') is-invalid @enderror" name="surat" id="inputPassword4" placeholder="Nomor Surat Keterangan" :value="old('surat')"  value="{{old('surat')}}">
                    @error ('surat')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tanggal Surat Keterangan</label>
                    <input type="date" class="form-control @error ('tgl_surat') is-invalid @enderror" name="tgl_surat" id="tgl_surat" name="tgl_surat" placeholder="" :value="old('tgl_surat')"  value="{{old('tgl_surat')}}">
                    @error ('tgl_surat')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Program Studi</label>
                    <input type="text" class="form-control @error ('program_studi') is-invalid @enderror" name="program_studi" id="inputPassword4" name="program_studi" placeholder="Program Studi" :value="old('program_studi')"  value="{{old('program_studi')}}">
                    @error ('program_studi')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tahun Akademik</label>
                    <input type="text" name="tahun" name="tahun" class="form-control @error ('tahun') is-invalid @enderror" id="tgl_surat" name="tgl_surat" placeholder="2020-2021" :value="old('tahun')"  value="{{old('tahun')}}">
                  </div>
                </div>
                
                
                <fieldset class="form-fieldset mb-3">
                    <legend>File Persyaratan Administrasi</legend>
                    <div class="form-group ">
                        <label for="inputPassword3" >Surat Pengantar</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" :value="old('file')" >
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file')  }}
                              </div>
                          @enderror
                        </div>  
                        <label for="inputPassword3" >SK PNS</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file2') is-invalid @enderror" id="file" name="file2" :value="old('file2')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file2')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file2')  }}
                              </div>
                          @enderror
                        </div>  
                
                        <label for="inputPassword3" >Asli Surat Keterangan Terdaftar Sebagai Mahasiswa</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file4') is-invalid @enderror" id="file" name="file4" :value="old('file4')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file4')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file4')  }}
                              </div>
                          @enderror
                        </div> 
                        <label for="inputPassword3" >Legalir FC Akreditasi Program Studi Minimal B</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file5') is-invalid @enderror" id="file" name="file5" :value="old('file5')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file5')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file5')  }}
                              </div>
                          @enderror
                        </div>
                        <label for="inputPassword3" >Surat Pernyataan Proses Belajar Tidak Akan Mengganggu Jam Kerja</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file6') is-invalid @enderror" id="file" name="file6" :value="old('file6')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file6')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file6')  }}
                              </div>
                          @enderror
                        </div>
                        <label for="inputPassword3" >Surat Persetujuan Pimpinan Satuan Kerja</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file7') is-invalid @enderror" id="file" name="file7" :value="old('file7')">
                          <label class="custom-file-label" for="customFile">Choose File</label>
                          @error ('file7')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file7')  }}
                              </div>
                          @enderror
                        </div>
                    </div>
                  </fieldset>

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