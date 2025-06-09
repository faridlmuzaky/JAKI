@extends('layout.main')
@section('title', 'Rekapitulasi Disiplin Hakim')

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

    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Rekapitulasi Disiplin Ketua Pengadilan</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Rekapitulasi Disiplin Ketua Pengadilan</h4>
                </div>
                <div class="d-flex justify-content-end">
                    @if (Auth::User()->role==1)
                        
                    @endif
                </div>
            </div>

            {{-- Main Content  --}}
            <div class="col-lg-4 col-xl-12 mg-t-10">
                <div class="card">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h6 class="mg-b-5">Rekapitulasi Disiplin Ketua Pengadilan</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Rekapitulasi Disiplin Ketua Pengadilan</p>
                    </div>
                    <br>
                    <form class="form-inline" method="GET" action="{{ route('disiplin.rekap')}}">
                       
                                {{-- <div class="form-group mx-sm-3 mb-2">
                                    <select name="filter_satker" id="filter_satker" class="form-control">
                                        @foreach ($list_satker as $key)
                                            <option value="{{ $key->id_satker_sikep }}" {{ (collect($id_satker)->contains($key->id_satker_sikep)) ? 'selected':'' }}>
                                                {{ $key->nama_satker }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group mx-sm-3 mb-2">
                                    <select name="filter_bulan" id="filter_bulan" class="form-control">
                                        @foreach ($list_bulan as $key => $value)
                                            <option value="{{ $key }}" {{ (collect($bulan)->contains($key)) ? 'selected':'' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <select name="filter_tahun" id="filter_tahun" class="form-control">
                                        @foreach ($list_tahun as $thn)
                                            <option value="{{ $thn }}" {{ (collect($tahun)->contains($thn)) ? 'selected':'' }}>
                                                {{ $thn }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 d-flex">
                                    <button class="btn btn-primary mb-2" type="submit">Filter </button>
                                    {{-- <a href="#" class="btn btn-danger mb-2 ml-1" onclick="hapus_filter()">Hapus Filter</a> --}}
                                </div>
                    
                                <div class="form-group col-12 col-md-6 d-flex justify-content-end mt-2 mt-md-0">
                                </form>
                                    {{-- <form action="{{ route('disiplin.isiSemua') }}" method="POST" style="display:inline;"> --}}
                                        {{-- @csrf --}}
                                        {{-- <input type="hidden" name="id_satker" value="{{ request('filter_satker') }}">
                                        <input type="hidden" name="bulan" value="{{ request('filter_bulan') }}">
                                        <input type="hidden" name="tahun" value="{{ request('filter_tahun') }}"> --}}
                                        {{-- <button type="submit" class="btn btn-success">Isi Semua</button> --}}
                                        
                                        {{-- <a href="#" class="btn btn-success mb-2 ml-1" onclick="isi()">Isi Semua</a> --}}
                                        <a href="{{ route('disiplin.downloadRekapLaporan', [
                                            'filter_satker' => request('filter_satker'),
                                            'filter_bulan' => request('filter_bulan'),
                                            'filter_tahun' => request('filter_tahun')
                                                ]) }}" class="btn btn-warning">
                                            Buat Rekapitulasi
                                        </a>
                                        {{-- <button class="btn btn-warning" >Download Laporan</button> --}}
                                    {{-- </form> --}}
                                </div>
                        
                    
                    <!-- card-header -->
                    <div class="table-responsive">
                        <div class="card-body pd-20">
               
                            {{-- <table border="1" cellspacing="0" cellpadding="5" class="table mt-3 table-striped" id="tabel"> --}}
                            <table border="1" cellspacing="0" cellpadding="5" id="tabel">
                                <thead>
                                  <tr>
                                    <th rowspan="2">NO</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2">JABATAN</th>
                                    <th rowspan="2">SATUAN KERJA</th>
                                    <th colspan="7">URAIAN AKUMULASI TIDAK DIPATUHINYA JAM KERJA</th>
                                    <th rowspan="2">BENTUK PEMBINAAN</th>
                                    <th rowspan="2">KETERANGAN</th>
                                    <th rowspan="2">File Laporan</th>
                                  </tr>
                                  <tr>
                                    <th>t</th>
                                    <th>tam</th>
                                    <th>pa</th>
                                    <th>tap</th>
                                    <th>kti</th>
                                    <th>tk</th>
                                    <th>tms</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <!-- Isi data di sini -->
                                  @foreach ($data as $item)
                                  <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->gelar_depan . ' ' . $item->nama_lengkap . ' ' . $item->gelar_belakang }}</td>
                                    <td>{{$item->jabatan}}</td>
                                    <td>{{$item->satker}}</td>
                                    <td>{{$item->t}}</td>
                                    <td>{{$item->tam}}</td>
                                    <td>{{$item->pa}}</td>
                                    <td>{{$item->tap}}</td>
                                    <td>{{$item->kti}}</td>
                                    <td>{{$item->tk}}</td>
                                    <td>{{$item->tms}}</td>
                                    <td>{{$item->pembinaan}}</td>
                                    <td>{{$item->keterangan}}</td>
                                    <td>@php
                                        $link_file = DB::table('rekapitulasi_disiplin_hakim')
                                                    ->where('id_satker', '=', $item->id_satker)
                                                    ->where('bulan', '=', $bulan)
                                                    ->where('tahun', '=', $tahun)
                                                    ->get();
                                        
                                        @endphp
                                    
                                    @foreach($link_file as $result)
                                        <a href="{{asset('laporan').'/'.$result->file }}" class="btn btn-success" target="_blank"><i data-feather="arrow-down-circle" class="wd-10 mg-r-5"></i>Unduh</a>
                                    @endforeach
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              
                        </div><!-- card-body -->
                    </div>
                </div><!-- card -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Disiplin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3 form-group">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" id="nama" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" class="form-control" readonly>
                        </div>
                    </div>
                    
                    {{-- <h4>Pelanggaran Akumulasi Tidak Dipatuhinya Jam Kerja</h4> --}}

                    <fieldset class="form-fieldset">
                        <legend>URAIAN AKUMULASI TIDAK DIPATUHINYA JAM KERJA</legend>
                        <div class="form-row">
                            <div class="form-group col-md-4">                           
                                <label class="d-block">Terlambat (t)</label>
                                <input type="number" name="t" id="t" class="form-control">  
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block">Tidak Absen Masuk (tam)</label>
                                <input type="number" name="tam" id="tam" class="form-control">
                            </div>
                            <div class="form-group col-md-4"> 
                                <label class="d-block">Pulang Awal (pa)</label>
                                <input type="number" name="pa" id="pa" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6"> 
                                <label class="d-block" >Tidak Absen Pulang (tap)</label>
                                <input type="number" name="tap" id="tap" class="form-control">
                            </div>
                            <div class="form-group col-md-6"> 
                                <label class="d-block" >Keluar Kantor Tidak Ijin (kti)</label>
                                <input type="number" name="kti" id="kti" class="form-control">
                            </div>
                            <div class="form-group col-md-4">  
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">  
                                <label class="d-block">Tanpa Keterangan (tk)</label>
                                <input type="number" name="tk" id="tk" class="form-control">
                            </div>
                            <div class="form-group col-md-6">  
                                <label class="d-block">Tidak Masuk Sakit Tidak Mengajukan Cuti Sakit (tms)</label>
                                <input type="number" name="tms" id="tms" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">  
                                <label class="d-block">Bentuk Pembinaan</label>
                                <textarea name="bentuk_pembinaan" id="bentuk_pembinaan" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-6">  
                                <label class="d-block">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            </div>
                        </div>
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#tabel').dataTable({
        // responsive:true
        "drawCallback": function(settings) {
            feather.replace();
            },
                responsive: true,
                language: {
                    searchPlaceholder: 'Cari...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });


 

            $(document).ready(function() {
    // Tombol Edit diklik
    $('.btn-edit').click(function() {
        var id = $(this).data('id');

        $.get("{{ url('disiplin') }}/" + id + "/edit", function(data) {
            $('#editForm').attr('action', "{{ url('disiplin') }}/" + id);
            $('#nama').val(data.nama);
            $('#jabatan').val(data.jabatan);
            $('#t').val(data.t);
            $('#tam').val(data.tam);
            $('#pa').val(data.pa);
            $('#tap').val(data.tap);
            $('#kti').val(data.kti); // pastikan id input di form HTML juga 'kti'
            $('#tk').val(data.tk);
            $('#tms').val(data.tms);
            $('#bentuk_pembinaan').val(data.pembinaan);
            $('#keterangan').val(data.keterangan);
            $('#editModal').modal('show');
        });
    });

    // Form Edit disubmit
    $('#editForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize() + "&_method=PUT", // kasih _method=PUT
            success: function(response) {
                $('#editModal').modal('hide');

                // SweetAlert untuk sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.success || 'Data berhasil diperbarui',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(); // Refresh halaman setelah berhasil update
                });

            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.message || 'Terjadi kesalahan. Silakan coba lagi.',
                    footer: 'Status: ' + xhr.status + ' ' + xhr.statusText
                });
            }
        });
    });
});


    </script>
@endsection
