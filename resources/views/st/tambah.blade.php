@extends('layout.main')
@section('title', 'Surat Tugas')

@section('content')
<style>
 
.suggestion-item,
.suggestion-item-instansi,
.suggestion-item-maksud,
.suggestion-item-alamat,
.suggestion-item-nomor-st {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    list-style: none;
}

.suggestion-item:hover,
.suggestion-item-instansi:hover,
.suggestion-item-maksud:hover,
.suggestion-item-alamat:hover,
.suggestion-item-nomor-st:hover {
    background-color: #cce5ff; /* sedikit lebih gelap saat hover */
}
</style>

<style>
/* Supaya lebih flat dan modern */
table.dataTable thead {
    background-color: #f8f9fa;
}

table.dataTable td,
table.dataTable th {
    vertical-align: middle !important;
    font-size: 12px;
    text-align: center !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.3em 0.8em;
    margin-left: 2px;
    border-radius: 0.25rem;
    border: 1px solid #dee2e6;
    background: #ffffff;
    color: #007bff !important;
    transition: all 0.2s;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #007bff;
    color: white !important;
}

#tabelPegawaiAjax th:first-child,
#tabelPegawaiAjax td:first-child {
    width: 20px;
    text-align: center;
    padding: 6px;
  }

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
<!-- Bootstrap 4 -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<!-- DataTables with Bootstrap 4 -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" rel="stylesheet"> --}}

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
          <h4 class="mg-b-0 tx-spacing--1">Pembuatan Surat Tugas</h4>
        </div>
        <div class="d-flex justify-content-end">
      
          <a href="{{url('/surattugas')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Tambah Surat Tugas</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Menambahkan Surat Tugas</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            
            <form method="POST" action="{{ url('/savest') }}" class="needs-validation" enctype="multipart/form-data">
              
              @csrf
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
            
                
      
                  <div class="form-group ">
                    <label>Menimbang</label>
                    {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                    <input type="text" class="form-control" id="menimbang" name="menimbang" rows="3" value="{{old('menimbang')}}">
                    
                    <ul id="suggestions" class="list-group"></ul>
                  </div>
                 
                  <div class="form-group ">
                    <label>Maksud Perjalanan Dinas</label>
                    {{-- <label for="exampleFormControlTextarea1">Example textarea</label> --}}
                    <input type="text" class="form-control " id="maksud" name="maksud" rows="3" value="{{old('maksud')}}">
                    <ul id="suggestions_maksud" class="list-group"></ul>
                    
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
                      <input type="text" name="kota" class="form-control" value="{{old('kota')}}">
                      
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Alamat Tujuan</label>
                      <input type="text" name="alamat" id="alamat" class="form-control" value="{{old('alamat')}}">
                      <ul id="suggestions_alamat" class="list-group"></ul>
                      
                      
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

                  <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Waktu Mulai</label>
                        <input id="inputTime2" type="time" name="waktu_mulai" class="form-control mg-t-10" placeholder="hh:mm" value="09:00">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Waktu Selesai</label>
                        <input id="inputTime2" type="text" name = "waktu_mulai" class="form-control mg-t-10" placeholder="hh:mm" value="s.d Selesai" disabled>
                        
                    </div>
                  </div>
                  

                <div class="form-row align-middle">
                    <div class="form-group col-md-12 ">
                        <label>Pejabat Penandatangan</label>
                        <select class="custom-select @error ('pejabat') is-invalid @enderror" name="pejabat">
                        <option value="" selected>- Silahkan Pilih -</option>
                        @foreach ($user as $user)
                            <option value="{{$user->nip}}">{{$user->nama_lengkap ." - ". $user->kelompok_jabatan }}</option>
                        @endforeach
                        
                        </select>
                        {{-- <a href="" class="btn btn-sm pd-x-15 btn-secondary btn-icon"><i data-feather="plus" class="wd-10 mg-r-5"></i></a> --}}
                        @error ('atasan_langsung')  
                            <div class="invalid-feedback">  
                            {{$message }}
                            </div> 
                        @enderror
                    </div>                       
                </div>


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

              {{-- Hidden input untuk pengiriman --}}
              <div id="pegawai-inputs"></div>



                <div class="form-row">
                  <div class="form-group col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck3" checked name="dipa">
                        <label class="custom-control-label" for="customCheck3">Dibiayai oleh DIPA (dengan SPD)</label>
                    </div>
                  </div>
                </div>
                          <div class="mt-2">

                              <button type="submit" class="btn btn-success"><i data-feather="save" class="wd-20 mg-r-5"></i>Simpan</button>
                          </div>
            </form>
            
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  {{-- </div> --}}
</div><!-- content -->  


<!-- Modal Cari Pegawai -->
{{-- <div class="modal fade" id="modalCariPegawai" tabindex="-1" role="dialog" aria-labelledby="modalCariPegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cari dan Pilih Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="searchPegawai" class="form-control mb-3" placeholder="Cari nama, NIP, jabatan...">

        <table class="table table-hover table-sm" id="tabel-pegawai-cari">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawaiList as $pegawai)
                <tr data-id="{{ $pegawai->id }}"
                    data-nama="{{ $pegawai->nama_lengkap }}"
                    data-nip="{{ $pegawai->nip }}"
                    data-jabatan="{{ $pegawai->jabatan }}"
                    data-unit="{{ $pegawai->satker }}">
                    <td>{{ $pegawai->nama_lengkap }}</td>
                    <td>{{ $pegawai->nip }}</td>
                    <td>{{ $pegawai->jabatan }}</td>
                    <td>{{ $pegawai->satker }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" onclick="tambahPegawaiFromModal(this)">Pilih</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div> --}}
<!-- Modal Cari Pegawai -->
<div class="modal fade" id="modalCariPegawai" tabindex="-1" role="dialog" aria-labelledby="modalCariPegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
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
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
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


<!-- Load jQuery dan jQuery UI -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // var cleaveF = new Cleave('#inputTime2', {
    // time: true,
    // timePattern: ['h', 'm']
    // });


   

</script>
<script>
 $('#menimbang').on('keyup', function() {
    let query = $(this).val();

    if (query.length >= 2) {
        $.ajax({
            url: '/addst/menimbang',
            type: 'GET',
            data: { term: query },
            success: function(data) {
                $('#suggestions').empty();
                data.forEach(function(item) {
                    $('#suggestions').append('<li class="list-group-item suggestion-item">' + item + '</li>');
                });
            }
        });
    } else {
        $('#suggestions').empty();
    }
});

 $('#maksud').on('keyup', function() {
    let query = $(this).val();

    if (query.length >= 2) {
        $.ajax({
            url: '/addst/maksud',
            type: 'GET',
            data: { term: query },
            success: function(data) {
                $('#suggestions_maksud').empty();
                data.forEach(function(item) {
                    $('#suggestions_maksud').append('<li class="list-group-item suggestion-item-maksud">' + item + '</li>');
                });
            }
        });
    } else {
        $('#suggestions_maksud').empty();
    }
});
 $('#instansi').on('keyup', function() {
    let query = $(this).val();

    if (query.length >= 2) {
        $.ajax({
            url: '/addst/instansi',
            type: 'GET',
            data: { term: query },
            success: function(data) {
                $('#suggestions_instansi').empty();
                data.forEach(function(item) {
                    $('#suggestions_instansi').append('<li class="list-group-item suggestion-item-instansi">' + item + '</li>');
                });
            }
        });
    } else {
        $('#suggestions_instansi').empty();
    }
});
 $('#alamat').on('keyup', function() {
    let query = $(this).val();

    if (query.length >= 2) {
        $.ajax({
            url: '/addst/instansi_alamat',
            type: 'GET',
            data: { term: query },
            success: function(data) {
                $('#suggestions_alamat').empty();
                data.forEach(function(item) {
                    $('#suggestions_alamat').append('<li class="list-group-item suggestion-item-alamat">' + item + '</li>');
                });
            }
        });
    } else {
        $('#suggestions_alamat').empty();
    }
});
 $('#nomor_st').on('keyup', function() {
    let query = $(this).val();

    if (query.length >= 2) {
        $.ajax({
            url: '/addst/nomor_st',
            type: 'GET',
            data: { term: query },
            success: function(data) {
                $('#suggestions_nomor_st').empty();
                data.forEach(function(item) {
                    $('#suggestions_nomor_st').append('<li class="list-group-item suggestion-item-nomor-st">' + item + '</li>');
                });
            }
        });
    } else {
        $('#suggestions_nomor_st').empty();
    }
});

$(document).on('click', '.suggestion-item', function() {
    $('#menimbang').val($(this).text());
    $('#suggestions').empty();
});
$(document).on('click', '.suggestion-item-instansi', function() {
    $('#instansi').val($(this).text());
    $('#suggestions_instansi').empty();
});
$(document).on('click', '.suggestion-item-maksud', function() {
    $('#maksud').val($(this).text());
    $('#suggestions_maksud').empty();
});
$(document).on('click', '.suggestion-item-alamat', function() {
    $('#alamat').val($(this).text());
    $('#suggestions_alamat').empty();
});
$(document).on('click', '.suggestion-item-nomor-st', function() {
    $('#nomor_st').val($(this).text());
    $('#suggestions_nomor_st').empty();
});


    
</script>




<script>
var pegawaiTerpilih = new Set();

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
        
        // Hapus dari DOM
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
var PPNPNTerpilih = new Set();

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

@endsection