@extends('layout.main')
@section('title', 'Perjadin')

@section('content')
<style>
   table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px; /* Mengecilkan tulisan */
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
</style>
<style>
    .plh-badge {
        background: linear-gradient(to right, #ffc107, #ff9800);
        color: #fff;
        font-weight: bold;
        box-shadow: 0 0 6px rgba(255, 193, 7, 0.5);
        transition: transform 0.2s ease;
    }

    .plh-badge:hover {
        transform: scale(1.05);
    }
</style>
<div class="content-body">
    {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Surat Tugas</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Surat Tugas</h4>
        </div>
        <div class="d-flex justify-content-end">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/addst')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Surat Tugas</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            {{-- @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
            @endif
            @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
            @endif --}}
            <h6 class="mg-b-5">Surat Tugas</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Daftar surat tugas yang telah diinput.</p>
            <br>
            <form class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                  <input type="date" class="form-control" id="tanggal" value="{{ $tanggal }}">
              </div>
              <a href="#" class="btn btn-primary mb-2" onclick="filter()">Filter Tanggal</a>
              <a href="#" class="btn btn-danger mb-2 ml-2" onclick="hapus_filter()">Hapus Filter</a>
              
          </form>
          </div><!-- card-header -->
          <div class="table-responsive">
          <div class="card-body pd-20">
            <table class="table mt-3" id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Penugasan Kepada</th>
                        <th scope="col">Maksud Perjalanan Dinas</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Tanggal Penugasan</th>
                        <th scope="col">SPD </th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                @foreach ($data as $item)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-icon btn-pegawai mb-1" data-id="{{ $item->id }}" id="btn-pegawai">
                          <i data-feather="users"></i>
                        </button>
                      @if ($item->plh)
                        <br>
                        <span 
                            class="badge badge-pill badge-warning plh-badge" 
                            data-toggle="tooltip" 
                            title="Perlu Penunjukan PLH">
                            <i class="fas fa-star mr-1"></i> PLH
                        </span>
                      @endif
                    </td>
                    <td>{{$item->maksud}}</td>
                    <td>{{$item->instansi_tujuan}}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tgl_awal)->translatedFormat('j F Y') }} s.d. 
                        {{ \Carbon\Carbon::parse($item->tgl_akhir)->translatedFormat('j F Y') }}
                       <br> <small class="text-muted">
                            (Total: {{ \Carbon\Carbon::parse($item->tgl_awal)->diffInDays($item->tgl_akhir) + 1 }} hari)
                        </small>
                    </td>
                    <td class="text-center">{{ $item->dipa == '1' ? 'YA' : 'TIDAK' }}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i data-feather="list"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          
                          
                          {{-- <butto  class="dropdown-item btn-edit-st" id="btn-edit-st" data-id="{{ $item->id }}"><i data-feather="edit-3" class="wd-15 mg-r-5">></i>Edit</butto> --}}
                          <button class="dropdown-item btn-edit-st" id="btn-edit-st" data-id="{{ $item->id }}"><i data-feather="edit-3" class="wd-15 mg-r-5" ></i>Edit</button>
                          <button class="dropdown-item btn-cetak-st" id="btn-cetak-st" data-id="{{ $item->id }}"><i data-feather="file-text" class="wd-15 mg-r-5" ></i>Cetak Surat Tugas</button>
                          {{-- <a class="dropdown-item" href=""><i data-feather="file" class="wd-15 mg-r-5">></i>Cetak SPD</a> --}}
                          <div class="dropdown-divider"></div>
                          <button class="dropdown-item" id="btn-hapus" name="btn-hapus" data-id="{{ $item->id }}" ><i data-feather="delete" class="wd-15 mg-r-5"></i>Delete</button>
                          <div class="dropdown-divider"></div>
                          {{-- <a class="dropdown-item" href="/izbel/{{$item->id}}/historyuser"><i data-feather="clock" class="wd-15 mg-r-5"></i>History Usulan</a> --}}
                          {{-- <a class="dropdown-item" href="/izbel/{{$item->id}}/waizbel"><i data-feather="send" class="wd-15 mg-r-5"></i>Kirim Whatsapp</a> --}}
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
            </table>
            </table>
  
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    {{-- </div><!-- container --> --}}
  </div>
</div><!-- content -->  


{{-- modal lihat penugasan pegawai --}}
<div class="modal fade" id="modalPegawai" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel4">Daftar Penugasan Pegawai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal-body">
            <table id="tabelPegawaiLihat" class="table table-hover  table-bordered rounded shadow-sm" style="width: 100%">
            <thead class="thead-light">
                <tr>
                  <th style="width: 20px; text-align: center;">No</th>
                  <th>Nama</th>
                  {{-- <th>NIP</th> --}}
                  <th>Jabatan</th>
                  <th>Satker</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
              </thead>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Tutup</button>
            {{-- <button type="button" class="btn btn-primary tx-13">Save changes</button> --}}
          </div>
        </div>
      </div>
    </div>

    {{-- modal cetak surat tugas --}}

{{-- modal Dowload penugasan pegawai --}}
<div class="modal fade" id="modalCetakST" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel4">Download Surat Tugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form id="formValidasi" name="formValidasi" enctype="multipart/form-data" action="{{ route('downloadST')}}" method="post">
            @csrf
                <div class="modal-body" id="modal-body">
                  <input type="hidden" name="id_st" id="id_st">
                  <div class="form-group">
                      <label for="jenis_st">Pilih Template Surat Tugas</label>
                      <select name="jenis_st" id="jenis_st" class="form-control">
                          <option value="1">Tanpa Lampiran</option>
                          <option value="2">Dengan Lampiran</option>
                          <option value="3">ST Dalam Kota</option>
                          {{-- <option value="2">ST</option> --}}
                      </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary tx-13">Download Surat Tugas</button>
                </div>
            </form>
          </div>
      </div>
</div>

{{-- modal Edit Pegawai--}}
<div class="modal fade" id="modalEditST" tabindex="-1" role="dialog">
      {{-- pertama --}}
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content tx-14">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Edit Surat Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modal-body">

                    <div id="validationErrors" class="d-none mb-3"></div>

                    <form method="POST" action="{{ url('/surattugas/saveeditst') }}" id="editForm" name="editForm" class="needs-validation" enctype="multipart/form-data">
                        @csrf

                        <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#datapokok" role="tab" aria-controls="home" aria-selected="true">Data Pokok Penugasan</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#datapegawai" role="tab" aria-controls="profile" aria-selected="false">Daftar Pegawai</a>
                          </li>

                        </ul>
                        <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">
                          <div class="tab-pane fade show active" id="datapokok" role="tabpanel" aria-labelledby="home-tab3">
                            {{-- <h6>Data Pokok Penugasan</h6> --}}
                            {{-- <p class="mg-b-0">Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore.</p> --}}
                          
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nomor Surat Tugas</label>
                                    <input type="text" name="nomor_st" id="nomor_st" class="form-control" value="{{old('nomor_st')}}">
                                    
                                    
                                    <ul id="suggestions_nomor_st" class="list-group"></ul>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="inputPassword4">Tanggal Surat Tugas</label>
                                    <input type="date" class="form-control @error ('tgl_st') is-invalid @enderror" name="tgl_st" id="tgl_st" placeholder="" value="{{ old('tgl_st', now()->format('Y-m-d')) }}"> 
                                  </div>
                                </div>
                            
                          
                              <div class="form-row">
                                <div class="form-group col-md-6 ">
                                  <label>Menimbang</label>
                                  {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                                  <input type="text" class="form-control" id="menimbang" name="menimbang" rows="3" value="{{old('menimbang')}}">
                                  
                                  <ul id="suggestions" class="list-group"></ul>
                                </div>
                              
                                <div class="form-group  col-md-6">
                                  <label>Maksud Perjalanan Dinas</label>
                                  {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                                  <input type="text" class="form-control " id="maksud" name="maksud" rows="3" value="{{old('maksud')}}">
                                  <ul id="suggestions_maksud" class="list-group"></ul>
                                  
                                </div>
                              </div>
                          
                          {{-- </div> --}}
     
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputEmail4">Instansi Tujuan</label>
                                    <input type="text" name="instansi" id="instansi" class="form-control" value="{{old('instansi')}}">
                                    <ul id="suggestions_instansi" class="list-group"></ul>
                                    
                                    
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="inputPassword4">Kota Tujuan</label>
                                    <input type="text" name="kota" id="kota" class="form-control" value="{{old('kota')}}">
                                    
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputEmail4">Alamat Tujuan</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{old('alamat')}}">
                                    <ul id="suggestions_alamat" class="list-group"></ul>
                                  </div>

                                   <div class="form-group col-md-6">
                                      <label>Pejabat Penandatangan</label>
                                      <select class="custom-select @error ('pejabat') is-invalid @enderror" name="pejabat" id="pejabat">
                                    
                                      
                                      </select>
                                      {{-- <a href="" class="btn btn-sm pd-x-15 btn-secondary btn-icon"><i data-feather="plus" class="wd-10 mg-r-5"></i></a> --}}
                                      @error ('atasan_langsung')  
                                          <div class="invalid-feedback">  
                                          {{$message }}
                                          </div> 
                                      @enderror
                                  </div>  
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="inputPassword4">Dari Tanggal</label>
                                      <input type="date" class="form-control @error ('tgl_awal') is-invalid @enderror" name="tgl_awal" id="tgl_awal" placeholder="" :value="old('tgl_awal')"  value="{{old('tgl_awal')}}">
                                      @error ('tgl_awal')  
                                          <div class="invalid-feedback">  
                                          {{$message }}
                                          </div> 
                                      @enderror
                                  </div>

                                  <div class="form-group col-md-6">
                                    <label for="inputPassword4">Sampai Tanggal</label>
                                    <input type="date" class="form-control @error ('tgl_akhir') is-invalid @enderror" name="tgl_akhir" id="tgl_akhir" placeholder="" :value="old('tgl_akhir')"  value="{{old('tgl_akhir')}}">
                                    @error ('tgl_akhir')  
                                        <div class="invalid-feedback">  
                                        {{$message }}
                                        </div> 
                                    @enderror
                                  </div>
                                </div>

                                {{-- <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="inputPassword4">Waktu Mulai</label>
                                      <input id="inputTime2" type="time" name="waktu_mulai" class="form-control mg-t-10" placeholder="hh:mm" value="09:00">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="inputPassword4">Waktu Selesai</label>
                                      <input id="inputTime2" type="text" name = "waktu_mulai" class="form-control mg-t-10" placeholder="hh:mm" value="s.d Selesai" disabled>
                                      
                                  </div>
                                </div> --}}
                                

                            {{-- Hidden input untuk pengiriman --}}
                            <div id="pegawai-inputs"></div>
                            <input name="id_surat_tugas" type="hidden" id="id_surat_tugas">

                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="customCheck3" name="dipa" id="dipa">
                                      <label class="custom-control-label" for="customCheck3">Dibiayai oleh DIPA (dengan SPD)</label>
                                  </div>
                                </div>
                              </div>
                    
                        </div>
                        <div class="tab-pane fade" id="datapegawai" role="tabpanel" aria-labelledby="profile-tab3">
                          <h6>Daftar Pegawai</h6>
                          <p class="mg-b-0">Silahkan perbaharui daftar pegawai yang ditugakan untuk melaksanakan perjalanan dinas.</p>
                          {{-- Tambah Pegawai --}}
                              <div class="card mt-4 mb-2">
                                <div class="card-header d-flex justify-content-between bg-light">
                                    <h6>Pegawai yang Ditugaskan</h6>
                                    {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCariPegawai">
                                        + Tambah Pegawai
                                    </button> --}}
                                    <div>
                                        <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modalCariPPNPN">
                                            + Tambah PPNPN
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCariPegawai">
                                            + Tambah Pegawai
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered mt-3" id="tabel-pegawai-terpilih">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Jabatan</th>
                                                <th>Unit Kerja</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Diisi oleh JS --}}
                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                          </div>
                        </div>

                
              

                    {{-- kedua --}}
                    
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary tx-13" name="btn-simpan" id="btn-simpan">Simpan Perubahan</button>
                  </div>
                  </form>
                </div>
              </div>
            
          </div>
      </div>
</div>

<!-- Modal Cari Pegawai -->
<div class="modal fade" id="modalCariPegawai" tabindex="-1" role="dialog" aria-labelledby="modalCariPegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Cari Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <table id="tabelPegawaiAjax" class="table table-hover  table-bordered rounded shadow-sm" style="width: 100%">
          <thead class="thead-light">
            <tr>
              <th style="width: 20px; text-align: center;">No</th>
              <th>Nama</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Satker</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cari PPNPN -->
<div class="modal fade" id="modalCariPPNPN" tabindex="-1" role="dialog" aria-labelledby="modalCariPPNPNLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Cari PPNPN</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <table id="tabelPPNPNAjax" class="table table-hover  table-bordered rounded shadow-sm" style="width: 100%">
          <thead class="thead-light">
            <tr>
              <th style="width: 20px; text-align: center;">No</th>
              <th>Nama</th>
              {{-- <th>NIP</th> --}}
              <th>Jabatan</th>
              <th>Satker</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>



@if(session('keep_modal_open'))
<script>
    $(document).ready(function() {
        $('#modalEditST').modal('show');
        
        // Isi form dengan data sebelumnya
        @if(old())
            const form = $('#editForm');
            @foreach(old() as $key => $value)
                if($('[name="{{ $key }}"]').length) {
                    $('[name="{{ $key }}"]').val('{{ $value }}');
                }
            @endforeach
        @endif
        
        // Tampilkan error validasi
        @if($errors->any())
            let errorHtml = '<div class="alert alert-danger"><ul>';
            @foreach($errors->all() as $error)
                errorHtml += '<li>{{ $error }}</li>';
            @endforeach
            errorHtml += '</ul></div>';
            
            $('#validationErrors').html(errorHtml).removeClass('d-none');
        @endif
    });
</script>
@endif
   


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>     
 
      $('#tabel').dataTable( {
        // responsive:true
        "drawCallback": function( settings ) {
            feather.replace();
        
    },
      responsive: true,
        language: {
          searchPlaceholder: 'Cari...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
  });

   // Menampilkan pesan SweetAlert jika session sukses ada
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    @if(session('error'))
        Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
    @endif
    </script>

<script>
      //click tombol validasi
   $(document).ready(function(){
        $('#tabel').on('click', '.btn-pegawai', function() {
            var id = $(this).data('id');
            var modal = $('#modalPegawai');
            var modalBody = modal.find('.modal-body');
            
            // console.log(id);
            // Tampilkan loading spinner
            modalBody.html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data pegawai...</p>
                </div>
            `);
        
        // Tampilkan modal
        modal.modal('show');

        // Ambil data pegawai via AJAX
        $.get("{{ url('surattugas/pegawai') }}/" + id, function(data) {
            if (data.success && data.pegawai.length > 0) {
                // Buat tabel untuk menampilkan data pegawai
                var html = `
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Pegawai</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Satuan Kerja</th>
                                </tr>
                            </thead>
                            <tbody>`;
                
                // Loop melalui data pegawai
                data.pegawai.forEach(function(pegawai, index) {
                    html += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${pegawai.nama_lengkap || '-'}</td>
                            <td>${pegawai.nip || '-'}</td>
                            <td>${pegawai.jabatan || '-'}</td>
                            <td>${pegawai.satker || '-'}</td>
                        </tr>`;
                });
 
                
                html += `
                            </tbody>
                        </table>
                    </div>`;
                
                modalBody.html(html);
            } else {
                modalBody.html(`
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Tidak ada data pegawai yang ditunjuk untuk surat tugas ini.
                    </div>
                `);
            }
        }).fail(function() {
            modalBody.html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Gagal memuat data pegawai. Silakan coba lagi.
                </div>
            `);
        });
    });
});
</script>


<script>
var PPNPNTerpilih = new Set();
var pegawaiTerpilih = new Set();

$(document).ready(function(){
   $('#tabel').on('click', '.btn-cetak-st', function() {
    var modal = $('#modalCetakST');
    var id = $(this).data('id');
    $('#id_st').val(id);
    modal.modal('show');
   });
});
</script>

<script>
$(document).ready(function(){
   $('#tabel').on('click', '.btn-edit-st', function() {
    var id = $(this).data('id');
    var modal = $('#modalEditST');
    var select = $('#pejabat');
      $.get("{{ url('surattugas') }}/" + id + "/edit", function(data) {
        // $('#editForm').attr('action', "{{ url('disiplin') }}/" + id);
        $('#nomor_st').val(data.datast.no_surat_tugas);
        $('#tgl_st').val(data.datast.tgl_surat_tugas);
        $('#menimbang').val(data.datast.menimbang);
        $('#maksud').val(data.datast.maksud);
        $('#instansi').val(data.datast.instansi_tujuan);
        $('#kota').val(data.datast.kota_tujuan);
        $('#alamat').val(data.datast.alamat_tujuan);
        $('#tgl_awal').val(data.datast.tgl_awal);
        $('#tgl_akhir').val(data.datast.tgl_akhir);
        $('#id_surat_tugas').val(data.datast.id);
        // $('#pejabat').val(data.datast.pejabat);

      var pejabat = data.datast.pejabat;
      
        // Kosongkan select terlebih dahulu
         select.empty();

        // Loop melalui data pegawai
        // Loop melalui data pegawai
         data.user.forEach(function(user) {
            // Buat elemen option
            var option = $('<option>', {
               value: user.nip,
               text: user.nama_lengkap + ' - ' + user.jabatan
            });
            
            // Tambahkan selected jika nip sama dengan pejabat
            if(user.nip == pejabat) {
               option.attr('selected', 'selected');
            }
            
            // Tambahkan option ke select
            select.append(option);
         });

          var dipa = data.datast.dipa;
          // console.log(dipa);
          if (dipa == 1) {
              $('input[name="dipa"]').prop('checked', true);
              // console.log($('#dipa').length);
          } else {
              $('input[name="dipa"]').prop('checked', false);
          }

        

            var pegawaiData = data.pegawaiData;
              // Target tabel (pastikan ID-nya sesuai)
            var table = $('#tabel-pegawai-terpilih tbody');
            table.empty(); // Kosongkan tabel sebelum mengisi

            // $(`#input-pegawai-${normalizedId}`).remove();
            $('input[name="pegawai_id[]"]').remove();

            // Loop melalui data pegawai
            $.each(pegawaiData, function(index, pegawai) {
                var row = $('<tr>');
                
                // Kolom No (otomatis, dimulai dari 1)
                row.append($('<td>').text(index + 1));
                
                // Kolom Nama
                row.append($('<td>').text(pegawai.nama_lengkap || '-'));
                
                // Kolom NIP
                row.append($('<td>').text(pegawai.nip || '-'));
                
                // Kolom Jabatan
                row.append($('<td>').text(pegawai.jabatan || '-'));
                
                // Kolom Unit Kerja
                row.append($('<td>').text(pegawai.satker || '-'));
                
                // Kolom Aksi (tombol hapus)
                var deleteBtn = $('<button>')
                    .addClass('btn btn-danger btn-sm btn-hapus')
                    .html('<i class="fa fa-trash"></i> Hapus')
                    .data('id', pegawai.nip_asli); // Simpan ID untuk referensi
                
                row.append($('<td>').append(deleteBtn));

                // tambah input html untuk mengisi id pegawai
                $('<input>')
                .attr({
                    type: 'hidden',
                    name: 'pegawai_id[]',
                    value: pegawai.nip_asli,
                    id: 'input-pegawai-' + pegawai.nip_asli
                })
                .appendTo('#pegawai-inputs');

                pegawaiTerpilih.add(pegawai.nip_asli);
                PPNPNTerpilih.add(pegawai.nip_asli);
                
                table.append(row);
            });

            // Event delegation untuk tombol hapus
            $('#tabel-pegawai-terpilih').on('click', '.btn-hapus', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                $(`#input-pegawai-${id}`).remove();

                pegawaiTerpilih.delete(id);
                PPNPNTerpilih.delete(id);

                row.remove();
                updateRowNumbers(); // Update nomor urut setelah hapus
            });

     
            // Fungsi untuk update nomor urut
            function updateRowNumbers() {
                $('#tabel-pegawai-terpilih tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

         modal.modal('show');

      });
     

   });
});
</script>

<script>

$(document).ready(function() {
    const tabel = $('#tabelPPNPNAjax').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("st_ppnpn.ajax") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'name', name: 'name' },
            { data: 'jabatan', name: 'jabatan' },
            // { data: 'jabatan', name: 'jabatan' },
            { data: 'satker', name: 'satker' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ],
        language: {
            search: "Cari Pegawai:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        },
        pageLength: 5,
        responsive: true,
    });

   // Fungsi untuk escape HTML guna mencegah XSS
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    window.tambahPPNPNAjax = function(id, nama, jabatan, unit) {
        // Normalisasi ID ke string untuk konsistensi
        const normalizedId = String(id);
        
        if (PPNPNTerpilih.has(normalizedId)) {
            console.log('Pegawai dengan ID ' + normalizedId + ' sudah ditambahkan');
            return;
        }
        
        console.log('Menambahkan pegawai:', normalizedId, nama, jabatan, unit);
        
        const rowCount = $('#tabel-pegawai-terpilih tbody tr').length + 1;
        
        // Escape semua data yang akan dimasukkan ke HTML
        const escapedNama = escapeHtml(nama);
        const escapedJabatan = escapeHtml(jabatan);
        const escapedUnit = escapeHtml(unit);
        
        // Buat elemen dengan jQuery untuk menghindari XSS dan inline event handler
        const newRow = $('<tr>').attr('data-id', normalizedId);
        
        newRow.append(
            $('<td>').addClass('text-center').text(rowCount),
            $('<td>').text(escapedNama),
            $('<td>').text('-'),
            $('<td>').text(escapedJabatan),
            $('<td>').text(escapedUnit),
            $('<td>').append(
                $('<button>')
                    .attr('type', 'button')
                    .addClass('btn btn-danger btn-sm')
                    .html('<i class="fas fa-trash-alt"></i> Hapus')
                    .on('click', function() {
                        hapusPPNPN(normalizedId);
                    })
            )
        );
        
        $('#tabel-pegawai-terpilih tbody').append(newRow);
        
        // Tambahkan input hidden
        $('<input>')
            .attr({
                type: 'hidden',
                name: 'pegawai_id[]',
                value: normalizedId,
                id: 'input-pegawai-' + normalizedId
            })
            .appendTo('#pegawai-inputs');
        

        PPNPNTerpilih.add(normalizedId);
    };

    // Fungsi hapusPegawai juga perlu menangani ID sebagai string
    window.hapusPPNPN = function(id) {
        const normalizedId = String(id);
        PPNPNTerpilih.delete(normalizedId);
        $(`tr[data-id="${normalizedId}"]`).remove();
        $(`#input-pegawai-${normalizedId}`).remove();
        // $(`.pegawai-data-group[data-id="${normalizedId}"]`).remove();
        $(`input#input-pegawai-${normalizedId}`).remove();
        updateNomorUrut();
    };

    function updateNomorUrut() {
        $('#tabel-pegawai-terpilih tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }

});

    @if(session('error'))
        Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
    @endif
</script>

<script>

$(document).ready(function() {
    // Fungsi untuk escape HTML guna mencegah XSS
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    const tabel = $('#tabelPegawaiAjax').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("st_pegawai.ajax") }}',
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false, 
                className: 'text-center' 
            },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'nip', name: 'nip' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'satker', name: 'satker' },
            { 
                data: 'aksi', 
                name: 'aksi', 
                orderable: false, 
                searchable: false,
                className: 'text-center'
            }
        ],
        language: {
            search: "Cari Pegawai:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        },
        pageLength: 5,
        responsive: true,
    });

    window.tambahPegawaiAjax = function(id, nama, nip, jabatan, unit) {
        // Normalisasi ID ke string untuk konsistensi
        const normalizedId = String(id);
        
        if (pegawaiTerpilih.has(normalizedId)) {
            console.warn('Pegawai dengan ID ' + normalizedId + ' sudah ditambahkan');
            return;
        }
        
        const rowCount = $('#tabel-pegawai-terpilih tbody tr').length + 1;
        
        // Escape semua data yang akan dimasukkan ke HTML
        const escapedNama = escapeHtml(nama);
        const escapedNip = escapeHtml(nip);
        const escapedJabatan = escapeHtml(jabatan);
        const escapedUnit = escapeHtml(unit);
        
        // Buat row baru
        const newRow = $('<tr>').attr('data-id', normalizedId);
        
        // Tambahkan kolom-kolom
        newRow.append(
            $('<td>').addClass('text-center').text(rowCount),
            $('<td>').text(escapedNama),
            $('<td>').text(escapedNip),
            $('<td>').text(escapedJabatan),
            $('<td>').text(escapedUnit),
            $('<td>').addClass('text-center').append(
                $('<button>')
                    .attr({
                        type: 'button',
                        'data-id': normalizedId
                    })
                    .addClass('btn btn-danger btn-sm btn-hapus-pegawai')
                    .html('<i class="fas fa-trash-alt"></i> Hapus')
            )
        );
        
        // Tambahkan ke tabel
        $('#tabel-pegawai-terpilih tbody').append(newRow);
        
        // Tambahkan input hidden
        $('<input>')
            .attr({
                type: 'hidden',
                name: 'pegawai_id[]',
                value: normalizedId,
                id: 'input-pegawai-' + normalizedId
            })
            .appendTo('#pegawai-inputs');
        
        // Tambahkan ke Set
        pegawaiTerpilih.add(normalizedId);
        
        // Update nomor urut
        updateNomorUrut();
    };

    // Event delegation untuk tombol hapus
    $(document).on('click', '.btn-hapus-pegawai', function() {
        const id = $(this).data('id');
        hapusPegawai(id);
    });

    window.hapusPegawai = function(id) {
        const normalizedId = String(id);
        
        
        
        $(`tr[data-id="${normalizedId}"]`).remove();
        $(`#input-pegawai-${normalizedId}`).remove();
        
        // Hapus dari Set
        pegawaiTerpilih.delete(normalizedId);
    
        // Update nomor urut
        updateNomorUrut();
        
        console.log('Pegawai dengan ID ' + normalizedId + ' telah dihapus');
    };

    function updateNomorUrut() {
        $('#tabel-pegawai-terpilih tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
});
</script>
<script>
$('#editForm').submit(function(e) {
    e.preventDefault();
    
    $('#btn-simpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
    
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: 'Data berhasil diperbarui',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            $('#btn-simpan').prop('disabled', false).html('Simpan Perubahan');
            
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger"><ul>';
                
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                    $(`[name="${key}"]`).addClass('is-invalid');
                    $(`#${key}_error`).text(value);
                });
                
                errorHtml += '</ul></div>';
                
                $('#validationErrors').html(errorHtml).removeClass('d-none');
                
                // Pertahankan modal terbuka
                $('#modalEditST').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan server'
                });
            }
        }
    });
});

// Reset form saat modal ditutup
$('#modalEditST').on('hidden.bs.modal', function() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    $('#validationErrors').addClass('d-none');
});
</script>

<script>
$(document).on('click', '#btn-hapus', function () {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data surat tugas dan pegawai terkait akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/surattugas/hapusst/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            });
        }
    });
});


    function filter() {
        var tanggal = $("#tanggal").val();
        console.log('tanggal = ' + tanggal);
        var url = '?tanggal=' + tanggal;
        window.location.href = url;
    }
    function hapus_filter() {
        window.location.href = 'surattugas';
    }
</script>


@endsection