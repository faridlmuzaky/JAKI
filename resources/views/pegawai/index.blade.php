@extends('layout.main')
@section('title', 'User Management')

@section('content')

<style>
    #syncSpinner.fade-in {
        opacity: 1;
        display: flex;
    }

    #syncSpinner.fade-out {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
</style>

<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Pegawai PTA Bandung</h4>
            </div>
            <div class="d-none d-md-block">
                @if ($role == 1)

                <button id="sync-pegawai" class="btn btn-primary">
                    Sinkronisasi Data Pegawai
                </button>
                <div id="progressContainer" style="margin-top: 20px; width: 100%; max-width: 500px; display: none;">
                    <div style="background-color: #f3f3f3; border: 1px solid #ccc; height: 25px; width: 100%; border-radius: 5px;">
                        <div id="progressBar" style="height: 100%; width: 0%; background-color: #4caf50; text-align: center; color: white; border-radius: 5px;">
                            0%
                        </div>
                    </div>
                    <div id="progressText" style="margin-top: 10px;"></div>
                </div>

                <button id="sync-jabatan" class="btn btn-info">
                    Sinkronisasi Data Jabatan
                </button>
                {{-- <button id="sync-satker" class="btn btn-info" disabled>
                    Sinkronisasi Data Satker
                </button> --}}
                @endif
            </div>
        </div>

        {{-- Main Content --}}
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
                    <h6 class="mg-b-5">Daftar Pegawai</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Daftar Pegawai Wilayah Pengadilan Tinggi Agama Bandung</p>

                    <div class="mg-t-30">
                        Filter Satuan Kerja
                    </div>

                    @if ($role == 1)
                    <form id="form1" method="POST" action="{{ url('/pegawai/satker') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm mg-b-10">
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <select class="custom-select" name="satker_id" id="satker_id">
                                    <option disabled>- Select -</option>
                                    @foreach ($satker as $row)
                                        <option value="{{ $row->id }}" {{ $row->id == $satker_selected ? 'selected' : '' }}>
                                            {{ $row->nama_satker }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <button type="submit" class="btn btn-success"><i data-feather="search" class="wd-20 mg-r-5"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                </div><!-- card-header -->

                <div class="table-responsive">
                    <div class="card-body pd-20">
                        <table class="table mt-3" id="tabel">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Satker</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="/pegawai/{{$item->nip}}/detail">{{ $item->gelar_depan . ' ' . $item->nama_lengkap . ' ' . $item->gelar_belakang }}</a></td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->jabatan == 'Panitera Muda' ? $item->unit_kerja : $item->jabatan }}</td>
                                <td>{{ $item->satker }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="list"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="/pegawai/{{$item->nip}}/detail">Detail</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="" data-toggle="modal"
                                                data-target="#">Hapus</a>
                                            @if ($role == 1)
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="/pegawai/{{$item->id}}/sync_jabatan">Sync Jabatan</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div><!-- container -->
    </div>
</div><!-- content -->
<!-- Spinner Area -->
<!-- Spinner Overlay -->
<div id="syncSpinner" style="
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(255, 255, 255, 0.9);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    transition: opacity 0.3s ease;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        {{-- <span class="visually-hidden">Loading...</span> --}}
    </div>
    <div id="syncText" style="margin-top: 1rem; font-weight: 500; color: #333;">Memulai sinkronisasi...</div>
</div>

<script>
    $('#tabel').dataTable({
        // responsive:true
        "drawCallback": function (settings) {
            feather.replace();

        },
        responsive: true,
        language: {
            searchPlaceholder: 'Cari...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });

    document.getElementById('sync-pegawai').addEventListener('click', function () {
        const now = new Date();
        const jam = now.toLocaleTimeString(); // default format lokal
        const spinner = document.getElementById('syncSpinner');
        const syncText = document.getElementById('syncText');

        // Fungsi untuk tampilkan spinner
        function showSpinner(message = 'Memulai sinkronisasi...') {
            spinner.style.display = 'flex';
            spinner.style.opacity = 1;
            syncText.textContent = message;
        }

        // Fungsi untuk sembunyikan spinner
        function hideSpinner(delay = 2000) {
            setTimeout(() => {
                spinner.style.opacity = 0;
                setTimeout(() => {
                    spinner.style.display = 'none';
                }, 300);
            }, delay);
        }

        // Tampilkan spinner
        showSpinner('Proses sinkronisasi data pegawai...');
        console.log("Mulai sync-pegawai: ", jam);
        fetch("{{ url('/api/sync-pegawai') }}", {
            method: "GET",
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // console.log(data.data); // tampilkan pesan sukses/gagal
            console.log(data.message); // tampilkan pesan sukses/gagal
            const now = new Date();
            const jam = now.toLocaleTimeString(); // default format lokal
            console.log("Selesai sync-pegawai: ", jam);
            hideSpinner(2000);
        })
        .catch(error => {
            console.error('Error:', error);
            hideSpinner(2000);
            const now = new Date();
            const jam = now.toLocaleTimeString(); // default format lokal
            console.log("Error sync-pegawai: ", jam);
            alert('Gagal melakukan sinkronisasi pegawai');        
        });
    });


    document.getElementById('sync-jabatan').addEventListener('click', function () {
        const now = new Date();
        const jam = now.toLocaleTimeString(); // default format lokal
        const spinner = document.getElementById('syncSpinner');
        const syncText = document.getElementById('syncText');

                // Fungsi untuk tampilkan spinner
        function showSpinner(message = 'Memulai sinkronisasi...') {
            spinner.style.display = 'flex';
            spinner.style.opacity = 1;
            syncText.textContent = message;
        }

        // Fungsi untuk sembunyikan spinner
        function hideSpinner(delay = 2000) {
            setTimeout(() => {
                spinner.style.opacity = 0;
                setTimeout(() => {
                    spinner.style.display = 'none';
                }, 300);
            }, delay);
        }

        // Tampilkan spinner
        showSpinner('Proses sinkronisasi data jabatan...');
        console.log("Mulai sync-jabatan: ", jam);
        fetch("{{ url('/api/sync-jabatan') }}", {
            method: "GET",
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // console.log(data.data); // tampilkan pesan sukses/gagal
            hideSpinner(2000);
            console.log(data.message); // tampilkan pesan sukses/gagal
            const now = new Date();
            const jam = now.toLocaleTimeString(); // default format lokal
            console.log("Selesai sync-jabatan: ", jam);
        })
        .catch(error => {
            console.error('Error:', error);
            hideSpinner(2000);
            const now = new Date();
            const jam = now.toLocaleTimeString(); // default format lokal
            console.log("Error sync-jabatan: ", jam);
            alert('Gagal melakukan sinkronisasi jabatan');
        });
    });

</script>

@endsection
