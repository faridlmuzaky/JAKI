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
            <h6 class="mg-b-5">Ubah Permohonan</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Mengubah permohonan izin belajar</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="/izbel/{{$izbel->id}}/update" class="needs-validation" enctype="multipart/form-data">
              @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">NIP</label>
                    <input type="text" name="nip" class="form-control @error ('nip') is-invalid @enderror" id="nip" :value="old('nip')" id="inputEmail4" placeholder="NIP"  value="{{$izbel->nip}}">
                    @error ('nip')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Nama</label>
                    <input type="text" name="nama_pegawai" class="form-control @error ('nama') is-invalid @enderror" id="inputPassword4" :value="old('nama')" placeholder="Nama Pegawai"  value="{{$izbel->nama_pegawai}}">
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
                            <option value="Ketua" @if ($izbel->jabatan=='Ketua') selected @endif>Ketua</option>
                            <option value="Wakil Ketua" @if ($izbel->jabatan=='Wakil Ketua') selected @endif>Wakil Ketua</option>
                            <option value="Hakim" @if ($izbel->jabatan=='Hakim') selected @endif>Hakim</option>
                            <option value="Panitera" @if ($izbel->jabatan=='Panitera') selected @endif>Panitera</option>
                            <option value="Sekretaris" @if ($izbel->jabatan=='Sekretaris') selected @endif>Sekretaris</option>
                            <optgroup label="Kepaniteraan">
                              <option value="Panitera Muda Banding" @if ($izbel->jabatan=='Panitera Muda Banding') selected @endif>Panitera Muda Banding</option>
                              <option value="Panitera Muda Hukum" @if ($izbel->jabatan=='Panitera Muda Hukum') selected @endif>Panitera Muda Hukum</option>
                              <option value="Panitera Muda Gugatan" @if ($izbel->jabatan=='Panitera Muda Gugatan') selected @endif>Panitera Muda Gugatan</option>
                              <option value="Panitera Muda Permohonan" @if ($izbel->jabatan=='Panitera Muda Permohonan') selected @endif>Panitera Muda Permohonan</option>
                              <option value="Panitera Pengganti" @if ($izbel->jabatan=='Panitera Pengganti') selected @endif>Panitera Pengganti</option>
                              <option value="Jurusita" @if ($izbel->jabatan=='Jurusita') selected @endif>Jurusita</option>
                              <option value="Jurusita Pengganti" @if ($izbel->jabatan=='Jurusita Pengganti') selected @endif>Jurusita Pengganti</option>
                            </optgroup>
                            <optgroup label="Kesekretariatan">
                              <option value="Kepala Bagian Umum dan Keuangan" @if ($izbel->jabatan=='Kepala Bagian Umum dan Keuangan') selected @endif>Kepala Bagian Umum dan Keuangan</option>
                              <option value="Kepala Bagian Perencanaan dan Kepegawaian" @if ($izbel->jabatan=='Kepala Bagian Perencanaan dan Kepegawaian') selected @endif>Kepala Bagian Perencanaan dan Kepegawaian</option>
                              <option value="Kasubbag Keuangan dan Pelaporan" @if ($izbel->jabatan=='Kasubbag Keuangan dan Pelaporan') selected @endif>Kasubbag Keuangan dan Pelaporan</option>
                              <option value="Kasubbag TU dan Rumah Tangga" @if ($izbel->jabatan=='Kasubbag TU dan Rumah Tangga') selected @endif>Kasubbag TU dan Rumah Tangga</option>
                              <option value="Kasubbag Rencana Program dan Anggaran" @if ($izbel->jabatan=='Kasubbag Rencana Program dan Anggaran') selected @endif>Kasubbag Rencana Program dan Anggaran</option>
                              <option value="Kasubbag Kepegawaian dan TI" @if ($izbel->jabatan=='Kasubbag Kepegawaian dan TI') selected @endif>Kasubbag Kepegawaian dan TI</option>
                              <option value="Kasubbag Perencanaan, TI dan Pelaporan" @if ($izbel->jabatan=='Kasubbag Perencanaan, TI dan Pelaporan') selected @endif>Kasubbag Perencanaan, TI dan Pelaporan</option>
                              <option value="Kasubbag Umum dan Keuangan">Kasubbag Umum dan Keuangan</option>
                              <option value="Kasubbag Kepegawaian dan Ortala" @if ($izbel->jabatan =='Kasubbag Kepegawaian dan Ortala') selected @endif>Kasubbag Kepegawaian dan Ortala</option>
                            </optgroup>
                            <optgroup label="Pelaksana">
                              <option value="Analis Akuntabilitas Kinerja Aparatur" @if ($izbel->jabatan =='Analis Akuntabilitas Kinerja Aparatur') selected @endif>Analis Akuntabilitas Kinerja Aparatur</option>
                              <option value="Analis Perencanaan, Evaluasi dan Pelaporan" @if ($izbel->jabatan =='Analis Perencanaan, Evaluasi dan Pelaporan') selected @endif>Analis Perencanaan, Evaluasi dan Pelaporan</option>
                              <option value="Pengelola Sistem dan Jaringan" @if ($izbel->jabatan =='Pengelola Sistem dan Jaringan') selected @endif">Pengelola Sistem dan Jaringan</option>
                              <option value="Penyusun Laporan Keuangan" @if ($izbel->jabatan =='Penyusun Laporan Keuangan') selected @endif>Penyusun Laporan Keuangan</option>
                              <option value="Pengadministrasi Persuratan" @if ($izbel->jabatan =='Pengadministrasi Persuratan') selected @endif>Pengadministrasi Persuratan</option>
                              <option value="Bendahara" @if ($izbel->jabatan =='Bendahara') selected @endif>Bendahara</option>
                              <option value="Pengelola Barang Milik Negara" @if ($izbel->jabatan =='Pengelola Barang Milik Negara') selected @endif>Pengelola Barang Milik Negara</option>
                              <option value="Analis SDM Aparatur"  @if ($izbel->jabatan =='Analis SDM Aparatur') selected @endif>Analis SDM Aparatur</option>
                              <option value="Pengelola Sistem Informasi Manajemen Kepegawaian"  @if ($izbel->jabatan =='Pengelola Sistem Informasi Manajemen Kepegawaian') selected @endif>Pengelola Sistem Informasi Manajemen Kepegawaian</option>
                              <option value="Pengelola Kepegawaian" @if ($izbel->jabatan =='Pengelola Kepegawaian') selected @endif>Pengelola Kepegawaian</option>
                              <option value="Pengadministrasi Hukum" @if ($izbel->jabatan =='Pengelola Hukum') selected @endif>Pengadministrasi Hukum</option>
                              <option value="Pengadministrasi Registrasi Perkara" @if ($izbel->jabatan =='Pengadministrasi Registrasi Perkara') selected @endif>Pengadministrasi Registrasi Perkara</option>
                              <option value="Pengelola Perkara" @if ($izbel->jabatan =='Pengelola Perkara') selected @endif>Pengelola Perkara</option>
                              <option value="Analis Perkara Peradilan" @if ($izbel->jabatan =='Analis Perkara Peradilan') selected @endif>Analis Perkara Peradilan</option>
                              <option value="Pengelola Keuangan" @if ($izbel->jabatan =='Analis Pengelola Keuangan') selected @endif>Pengelola Keuangan</option>
                              <option value="Pengolah Data Informasi dan Hukum" @if ($izbel->jabatan =='Pengolah Data Informasi dan Hukum') selected @endif>Pengolah Data Informasi dan Hukum</option>
                            </optgroup>
                            <optgroup label="Fungsional">
                              <option value="Analis Kepegawaian"  @if ($izbel->jabatan =='Analis Kepegawaian') selected @endif >Analis Kepegawaian</option>
                              <option value="Pranata Komputer" @if ($izbel->jabatan =='Pranata Komputer') selected @endif>Pranata Komputer</option>
                              <option value="Arsiparis" @if ($izbel->jabatan =='Arsiparis') selected @endif>Arsiparis</option>
                              <option value="Analis Pengelola Keuangan APBN" @if ($izbel->jabatan =='Analis Pengelola Keuangan APBN') selected @endif>Analis Pengelola Keuangan APBN</option>
                              <option value="Pranata Keuangan APBN" @if ($izbel->jabatan =='Pranata Keuangan APBN') selected @endif>Pranata Keuangan APBN</option>
                              <option value="Analis Perbendaharaan APBN" @if ($izbel->jabatan =='Analis Perbendaharaan APBN') selected @endif>Analis Perbendaharaan APBN</option>
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
                        <select class="custom-select @error ('gol') is-invalid @enderror" name="golongan" id="pendidikan">
                            <option value="" selected disabled>- Pilih -</option>
                            <option value="I/a" @if ($izbel->golongan =='I/a') selected @endif>I/a</option>
                            <option value="I/b" @if ($izbel->golongan =='I/b') selected @endif>I/b</option>
                            <option value="I/c" @if ($izbel->golongan =='I/c') selected @endif>I/c</option>
                            <option value="I/d" @if ($izbel->golongan =='I/d') selected @endif>I/d</option>
                            <option value="II/a" @if ($izbel->golongan =='II/a') selected @endif>II/a</option>
                            <option value="II/b" @if ($izbel->golongan =='II/b') selected @endif>II/b</option>
                            <option value="II/c" @if ($izbel->golongan =='II/c') selected @endif>II/c</option>
                            <option value="II/d" @if ($izbel->golongan =='II/d') selected @endif>II/d</option>
                            <option value="III/a" @if ($izbel->golongan =='III/a') selected @endif>III/a</option>
                            <option value="III/b" @if ($izbel->golongan =='III/b') selected @endif>III/b</option>
                            <option value="III/c" @if ($izbel->golongan =='III/c') selected @endif>III/c</option>
                            <option value="III/d" @if ($izbel->golongan =='III/d') selected @endif>III/d</option>
                            <option value="IV/a" @if ($izbel->golongan =='IV/a') selected @endif>IV/a</option>
                            <option value="IV/b" @if ($izbel->golongan =='IV/b') selected @endif>IV/b</option>
                            <option value="IV/c" @if ($izbel->golongan =='IV/c') selected @endif>IV/c</option>
                            <option value="IV/d" @if ($izbel->golongan =='IV/d') selected @endif>IV/d</option>
                            <option value="IV/e" @if ($izbel->golongan =='IV/e') selected @endif>IV/e</option>
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
                          <option value="S1" @if ($izbel->izin_pendidikan =='S1') selected @endif>S1</option>
                          <option value="S2" @if ($izbel->izin_pendidikan =='S2') selected @endif>S2</option>
                          <option value="S3" @if ($izbel->izin_pendidikan =='S3') selected @endif>S3</option>
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
                    <input type="text" class="form-control @error ('nama_universitas') is-invalid @enderror" name="nama_universitas" id="inputPassword4" placeholder="Nama Universitas" :value="old('nama_universitas')"  value="{{$izbel->nama_universitas}}">
                    @error ('universitas')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group ">
                    <label>Alamat Universitas</label>
                    <input type="text" class="form-control @error ('alamat') is-invalid @enderror" name="alamat_universitas" id="inputPassword4" placeholder="Alamat Universitas" :value="old('alamat')"  value="{{$izbel->alamat_universitas}}">
                    @error ('alamat_universitas')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                 
                {{-- </div> --}}
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>No Surat Keterangan Terdaftar Mahasiswa</label>
                    <input type="text" class="form-control @error ('nomor_s_keterangan') is-invalid @enderror" name="nomor_s_keterangan" id="inputPassword4" placeholder="Nomor Surat Keterangan" :value="old('surat')"  value="{{$izbel->nomor_s_keterangan}}">
                    @error ('nomor_s_keterangan')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tanggal Surat Keterangan</label>
                    <input type="date" class="form-control @error ('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_s_keterangan" placeholder="" :value="old('tgl_s_keterangan')"  value="{{$izbel->tgl_s_keterangan}}">
                    @error ('tgl_s_keterangan')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Program Studi</label>
                    <input type="text" class="form-control @error ('program_studi') is-invalid @enderror" name="program_studi" id="inputPassword4" name="program_studi" placeholder="Program Studi" :value="old('program_studi')"  value="{{$izbel->program_studi}}">
                    @error ('program_studi')  
                      <div class="invalid-feedback">  
                      {{$message }}
                      </div> 
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tahun Akademik</label>
                    <input type="text"  name="tahun_akademik" class="form-control @error ('tahun') is-invalid @enderror" id="tgl_surat" placeholder="2020-2021" :value="old('tahun')"  value="{{$izbel->tahun_akademik}}">
                  </div>
                </div>
                
                
                <fieldset class="form-fieldset mb-3">
                    <legend>File Persyaratan Administrasi</legend>
                    <div class="form-group ">
                        <label for="inputPassword3" >Surat Pengantar</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" value="{{asset('images').'/'.$izbel->file_surat_pengantar}}" >
                          <label class="custom-file-label" for="customFile">{{$izbel->file_surat_pengantar}}</label>
                          @error ('file')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file')  }}
                              </div>
                          @enderror
                        </div>  
                        <label for="inputPassword3" >SK PNS</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file2') is-invalid @enderror" id="file" name="file2" :value="old('file2')">
                          <label class="custom-file-label" for="customFile">{{$izbel->file_sk_pns}}</label>
                          @error ('file2')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file2')  }}
                              </div>
                          @enderror
                        </div>  
                        
                        <label for="inputPassword3" >Asli Surat Keterangan Terdaftar Sebagai Mahasiswa</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file4') is-invalid @enderror" id="file" name="file4" :value="old('file4')">
                          <label class="custom-file-label" for="customFile">{{$izbel->file_s_universitas}}</label>
                          @error ('file4')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file4')  }}
                              </div>
                          @enderror
                        </div> 
                        <label for="inputPassword3" >Legalisir FC Akreditasi Program Studi Minimal B</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file5') is-invalid @enderror" id="file" name="file5" :value="old('file5')">
                          <label class="custom-file-label" for="customFile">{{$izbel->file_akreditasi}}</label>
                          @error ('file5')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file5')  }}
                              </div>
                          @enderror
                        </div>
                        <label for="inputPassword3" >Surat Pernyataan Proses Belajar Tidak Akan Mengganggu Jam Kerja</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file6') is-invalid @enderror" id="file" name="file6" :value="old('file6')">
                          <label class="custom-file-label" for="customFile">{{$izbel->file_pernyataan}}</label>
                          @error ('file6')  
                              <div id="validationServer03Feedback" class="invalid-feedback">
                                  {{$errors->first('file6')  }}
                              </div>
                          @enderror
                        </div>
                        <label for="inputPassword3" >Surat Persetujuan Pimpinan Satuan Kerja</label>
                        <div class="custom-file mb-3">
                          <input type="file" class="custom-file-input @error ('file7') is-invalid @enderror" id="file" name="file7" :value="old('file7')" >
                          <label class="custom-file-label" for="customFile">{{$izbel->file_rekomendasi}}</label>
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