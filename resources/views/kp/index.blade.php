@extends('layout.main')
@section('title', 'Input Usul Kenaikan Pangkat')

@section('content')
<style>
    .nav-tabs .nav-link {
        white-space: normal !important; /* Memungkinkan text wrap */
        text-align: center; /* Agar teks rata tengah (opsional) */
        line-height: 1.; /* Jarak antar baris */
        padding-top: 2rem;    /* Atas */
        padding-bottom: 1rem; /* Bawah */
        
    }

    
</style>

    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usul Kenaikan Pangkat</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Usul Kenaikan Pangkat</h4>
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
                        <h6 class="mg-b-5">Input Usul Kenaikan Pangkat</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Data Usulan Kenaikan Pangkat</p>
                    </div>
                    <br>
                    
                                   
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4">
                            @for ($i = 1; $i <= 3; $i++)
                                <li class="nav-item" style="flex: 1; min-width: 120px;">
                                    <a class="nav-link {{ $step == $i ? 'active' : '' }} d-flex flex-column align-items-center py-4 ">
                                        <span>Langkah {{ $i }}</span>
                                        <small class="fw-normal">
                                            @switch($i)
                                                @case(1) Pilih Jenis Prosedur @break
                                                @case(2) Pilih Pegawai @break
                                                @case(3) Input Dokumen Usulan @break
                                                {{-- @case(4) Resume @break
                                                @case(5) Kirim Usulan @break --}}
                                            @endswitch
                                        </small>
                                    </a>
                                </li>
                            @endfor
                        </ul>
                        
                        <!-- Step 1 Content -->
                        <form method="POST" action="{{ route('usulkp.step1.post') }}">
                            @csrf
                            <div class="form-row">
                              <div class="form-group col-md-3">
                                <label for="periode">Periode</label>
                                <input type="text" class="form-control" id="periode" name="periode" value="{{$periode}}" readonly>
                              </div>
                              <div class="form-group col-md-3">
                                <label for="inputPassword4">Tahun</label>
                                <input type="text" class="form-control" id="inputPassword4" name="tahun" value="{{$tahun}}" readonly>
                              </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="jenisKP">Jenis KP</label>
                                <select name="jenisKP" id="jenisKP" class="form-control">
                                    <option value="1">Kenaikan Pangkat Reguler</option>
                                    <option value="2">Kenaikan Pangkat Struktural</option>
                                    <option value="3">Kenaikan Pangkat Memperoleh Ijazah</option>
                                    <option value="4">Kenaikan Pangkat Jabatan Fungsional</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="kelompokJabatan">Rumpun Jabatan</label>
                                <select name="kelompokJabatan" id="kelompokJabatan" class="form-control">
                                    <option value="1">Hakim</option>
                                    <option value="2">Kepaniteraan/Kejurusitaan</option>
                                    <option value="3">Kesekretariatan</option>
                                </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-submit">Lanjutkan</button>
                          </form>
                    
                    </div>  
                </div><!-- card -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

<!-- Modal -->
{{-- @media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
} --}}

{{-- modal kirim --}}
>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
   $(document).ready(function() {

            // Fungsi untuk enable/disable tombol submit
            function toggleSubmitButton() {
                if ($('#periode').val() === 'PERIODE_TIDAK_DIKETAHUI') {
                    $('#btn-submit').prop('disabled', true);
                } else {
                    $('#btn-submit').prop('disabled', false);
                }
            }

            // Cek saat halaman pertama kali dimuat
            toggleSubmitButton();

            // Cek saat nilai input berubah
            $('#periode').on('input change', function() {
                toggleSubmitButton();
            });

            // Inisialisasi DataTables
            $('#tabel').dataTable({
                responsive: true,
                drawCallback: function(settings) {
                    feather.replace();
                },
                language: {
                    searchPlaceholder: 'Cari...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            // Inisialisasi wizard
            $('#wizard1').steps({
                headerTag: 'h3',
                bodyTag: 'section',
                autoFocus: true,
                titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
            });

            

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
    </script>

@endsection
