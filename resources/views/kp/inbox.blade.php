@extends('layout.main')
@section('title', 'Inbox Usul Kenaikan Pangkat')

@section('content')
<style>
    .nav-tabs .nav-link {
        white-space: normal !important; /* Memungkinkan text wrap */
        text-align: center; /* Agar teks rata tengah (opsional) */
        line-height: 1.; /* Jarak antar baris */
        padding-top: 2rem;    /* Atas */
        padding-bottom: 1rem; /* Bawah */
        
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

    .custom-loader {
        position: absolute;
        top: 50%;
        left: 50%;
        display: flex;
        gap: 0.5rem;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .custom-loader span {
        width: 12px;
        height: 12px;
        background: #007bff;
        border-radius: 50%;
        animation: bounce 0.6s infinite alternate;
    }

    .custom-loader span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .custom-loader span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(-15px);
        opacity: 0.6;
    }
}

.nip-text {
  font-family: monospace;
  color: #555;
  margin-right: 5px;
}

.btn-copy-nip:hover {
  background: #e9ecef;
}
.btn-copy-nip i {
  font-size: 12px;
}

/* Style tombol seragam */
.btn-copy-uniform {
  width: 100px; /* Lebar tetap */
  height: 32px; /* Tinggi tetap */
  padding: 5px;
  font-size: 12px;
  /* background: #f8f9fa; */
  border: 1px solid #dee2e6;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.flat-accordion .accordion-item {
    border: 1px solid #d0dce5;
    border-radius: 8px;
    margin-bottom: 12px;
    background-color: #f8fbff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.flat-accordion .accordion-item:hover {
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
}

.flat-accordion .accordion-header {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    background-color: #e8f1fb;
    color: #2c3e50;
    transition: background-color 0.3s ease;
}

.flat-accordion .accordion-header:hover {
    background-color: #d8e7f6;
}

.flat-accordion .accordion-title {
    flex: 1;
}

.flat-accordion .accordion-icon {
    transition: transform 0.3s ease;
    color: #1d4ed8;
}

.flat-accordion .accordion-content {
    display: none;
    padding: 0;
    background-color: #ffffff;
    border-top: 1px solid #e3e3e3;
}

.flat-accordion .pdf-viewer {
    width: 100%;
    height: 500px;
    border: none;
}

.pdf-viewer {
  width: 100%;
  height: 500px; /* Sesuaikan tinggi PDF viewer */
  border: none;
}

.spinner-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
.spinner {
    text-align: center;
}
</style>
<div id="spinner" class="spinner-overlay">
    <div class="spinner">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
        <p>Memuat data...</p>
    </div>
</div>

    <div class="content-body">
        {{--  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inbox Usul Kenaikan Pangkat</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Inbox Usul Kenaikan Pangkat</h4>
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
                        <h6 class="mg-b-5">Inbox Usul Kenaikan Pangkat</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Data Usulan Kenaikan Pangkat</p>
                    </div>
                    <div class="card-body pd-20">
                        {{-- <h6 class="mg-b-5">Filter</h6> --}}
                            <form class="" method="GET" action="{{ route('usulkp.inbox')}}">
                                
                                    <div class="form-row ">
                                        <div class="form-group col-md-3">
                                        <label >Kelompok Jabatan</label>
                                            <select name="filter_kategori_jabatan" id="filter_kategori_jabatan" class="custom-select">
                                                @foreach ($list_kategori as $ktgr => $value)
                                                    <option value="{{ $ktgr }}" {{ (collect($kategori_jabatan)->contains($ktgr)) ? 'selected':'' }}>
                                                        {{ $value}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                        <label >Periode Usulan</label>
                                            <select name="filter_periode" id="filter_periode" class="custom-select">
                                                @foreach ($list_periode as $key => $value)
                                                    <option value="{{ $key }}" {{ (collect($periode)->contains($key)) ? 'selected':'' }}>
                                                        {{ $value}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    

                                        <div class="form-group col-md-2">
                                            <label >Tahun</label>
                                            <select name="filter_tahun" id="filter_tahun" class="custom-select">
                                                @foreach ($list_tahun as $thn)
                                                    <option value="{{ $thn }}" {{ (collect($tahun)->contains($thn)) ? 'selected':'' }}>
                                                        {{ $thn }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 d-flex align-items-end">
                                            {{-- <label >Tahun</label> --}}
                                            <button class="btn btn-primary" type="submit"><i data-feather="eye" class="wd-10 mg-r-5"></i>Filter </button>
                                        </div>
                                        

                                    </div> <!-- akhir row -->                                
                            </form>
                    </div> <!-- card body -->
                    
            
                        
                       

                     
                </div><!-- card -->

                <div class="card mt-2">
                    <div class="table-responsive">
                        <div class="card-body pd-20">
               
                            {{-- <table border="1" cellspacing="0" cellpadding="5" class="table mt-3 table-striped" id="tabel"> --}}
                            <table border="1" cellspacing="0" cellpadding="5" id="tabel">
                                <thead>
                                  <tr>
                                    <th>NO</th>
                                    <th>NAMA/NIP</th>
                                    <th>JABATAN</th>
                                    <th>GOL LAMA</th>
                                    <th>SATKER</th>
                                    <th>JENIS KP</th>
                                    <th>PERIODE</th>
                                    <th>TANGGAL INPUT</th>
                                    <th>STATUS USULAN</th>
                                    <th>KETERANGAN</th>
                                    <th>AKSI</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <!-- Isi data di sini -->
                                  @foreach ($data as $item)
                                  <tr>
                                    <td>{{$loop->iteration}}</td>
                                        <td>{{$item->nama}}<br><span class="nip-text">{{$item->nip}}</span><button class=" btn btn-copy-nip" title="Salin NIP">
                                    <i data-feather="copy"></i>
                                    </button></td>
                                    <td>{{$item->jabatan}}</td>
                                    <td>{{$item->golongan_lama}}</td>
                                    <td>{{$item->satker}}</td>
                                    <td>
                                        @if($item->jenis_kp == 1)
                                            Reguler
                                        @elseif($item->jenis_kp == 2)
                                            Struktural
                                        @elseif($item->jenis_kp == 3)
                                            PI
                                        @elseif($item->jenis_kp == 4)
                                            Fungsional
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td>{{$item->periode}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        @if($item->status_siasn == 1)
                                            <span class="badge badge-pill badge-primary">Diusulkan SIASN</span>
                                        @elseif($item->status_siasn == 2)
                                            <span class="badge badge-pill badge-danger">Perbaikan</span>
                                        @elseif($item->status_siasn == 3)
                                            <span class="badge badge-pill badge-warning">TTD Pertek</span>
                                        @elseif($item->status_siasn == 4)
                                            <span class="badge badge-pill badge-success">SK Terbit</span>
                                        @elseif($item->status_siasn == 9)
                                            <span class="badge badge-pill badge-secondary">Tidak Dapat Diusulkan</span>
                                        @endif
                                    </td>
                                    <td>{{$item->keterangan}}</td>
                                    <td>
                                        <button class="btn btn-success btn-lihat btn-copy-uniform" id = "btn-lihat"
                                        data-id={{ $item->id}}>lihat</button>
                                        <button class="btn btn-primary btn-edit btn-copy-uniform" id = "btn-edit"
                                        data-id={{ $item->id}}>edit</button>
                                        @if (Auth::User()->role == 1)
                                        <button class="btn btn-warning btn-validasi btn-copy-uniform" id = "btn-validasi"
                                        data-id={{ $item->id}}>validasi</button>
                                        @endif
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              
                        </div><!-- card-body -->
                    </div>
                </div>
            </div>
        {{-- </div> <!-- container --> --}}
    </div> <!-- content -->

<!-- Modal -->
{{-- @media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
} --}}

{{-- modal kirim --}}
{{-- modal edit --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Usulan Kenaikan Pangkat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    {{-- id hidden --}}
                    <input type="hidden" name="id_usulan" id="id_usulan">
                    <ul class="nav nav-tabs nav-justified " id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active d-flex flex-column align-items-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="Data Usul" aria-selected="true">
                            <div class="nav-text">DATA USUL</div></a>
                        </li>
                        {{-- <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="Data Usul" aria-selected="true">DATA USUL</a>
                        </li> --}}
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">DOKUMEN PERSYARATAN</a>
                        </li>
                    </ul>
                      <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                         

                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label class="form-label">NIP</label>
                                        <input type="text" id="nip" name="nip" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" id="jabatan" name="jabatan" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan Kerja</label>
                                        <input type="text" id="satker" name="satker" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label for="jenisKP">Jenis KP</label>
                                            <select name="jenisKP" id="jenisKP" class="form-control">
                                                <option value="1">Kenaikan Pangkat Reguler</option>
                                                <option value="2">Kenaikan Pangkat Struktural</option>
                                                <option value="3">Kenaikan Pangkat Memperoleh Ijazah</option>
                                                <option value="4">Kenaikan Pangkat Jabatan Fungsional</option>
                                            </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kelompokJabatan">Rumpun Jabatan</label>
                                            <select name="kelompokJabatan" id="kelompokJabatan" class="form-control">
                                                <option value="1">Hakim</option>
                                                <option value="2">Kepaniteraan/Kejurusitaan</option>
                                                <option value="3">Kesekretariatan</option>
                                            </select>
                                    </div>
                                </div>
                                {{--  batas isi tab biodata --}}

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="form-row">
                                    
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File SK KP</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" class="btn btn-sm btn-success preview-btn" id="btn_kp" name="btn_kp">Lihat File</button>
                                                    </div>
                                        
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File CPNS</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" class="btn btn-sm btn-success preview-btn" id="btn_cpns" name="btn_cpns">Lihat File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File Jabatan</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" id="btn_jabatan" name="btn_jabatan" class="btn btn-sm btn-success preview-btn">Lihat File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File SPP</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" id="btn_spp" name="btn_spp" class="btn btn-sm btn-success preview-btn">Lihat File</button>
                                                    </div>
                                                </div>
                                   
                                </div>
        
                                <div class="form-row mb-3 no-gutters">
                                    <div class="col-sm-3" style="padding-right: 0; padding-left: 0;"> 
                                        <label for="customFile" >File SKP Tahun {{date('Y')-1}}</label>
                                        <div class="custom-file">                          
                                            <input type="file" name="fileSKPTahun1" class="custom-file-input" id="fileSKPTahun1" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File SKP {{ date('Y')-1 }} (PDF)</label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 pe-0" style="padding-left: 0; padding-right: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" name="btn_skp1" id="btn_skp1" class="btn btn-warning preview-pdf" id="btn_skp1" name="btn_skp1">Preview</a>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-sm-2 ps-0" style="padding-right: 0; padding-left: 0;">
                                        <label for="customFile" >File SKP Tahun {{date('Y')-2}}</label>
                                        <div class="custom-file"> 
                                            <input type="file" name="fileSKPTahun2" class="custom-file-input" id="fileSKPTahun2" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File SKP {{ date('Y')-2 }} (PDF)</label>
                                            {{-- <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small>  --}}
                                        </div>
                                    </div>
                                    <div class="col-sm mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 ps-0" style="padding-left: 0; padding-right: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" name="btn_skp2" id="btn_skp2" class="btn btn-warning preview-pdf"  id="btn_skp2" name="btn_skp2">Preview</a>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-sm-3" style="padding-right: 0; padding-left: 0;"> 
                                        <label for="customFile" >File Ijazah</label>
                                        <div class="custom-file">                          
                                            <input type="file" name="fileIjazah" class="custom-file-input" id="fileIjazah" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File Ijazah (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                        {{-- <input type="text" name="isi_ijazah" id="isi_ijazah"> --}}
                                    </div>
                                    <div class="col-sm mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 pe-0" style="padding-left: 0; padding-right: 0;">
                                        <a href="" class="btn btn-warning preview-pdf"   id="btn_ijazah" name="btn_ijazah">Preview</a>
                                        
                                    </div>
                                </div>
        
 
        
                                <div class="form-row mb-2 no-guttters">
                                    <div class="col-md-3 ps-0" style="padding-right: 0; padding-left: 0;">
                                        <label for="customFile" >File Transkrip</label>
                                        <div class="custom-file"> 
                                            <input type="file" name="fileTranskrip" class="custom-file-input" id="fileTranskrip" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File Transkrip (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 ps-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf " id="btn_transkrip" name="btn_transkrip">Preview</a>
                                        {{-- </div> --}}
                                    </div>

                                    <div class="col-md-2" style="padding-right: 0; padding-left: 0;"> 
                                        <label for="customFile" >STLUD</label>
                                        <div class="custom-file">                          
                                            <input type="file" name="fileSTLUD" class="custom-file-input" id="fileSTLUD" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">STLUD (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan PI/Struktural</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 pe-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf" id="btn_stlud" name="btn_stlud" >Preview</a>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-md-3 ps-0" style="padding-right: 0; padding-left: 0;">
                                        <label for="customFile" >Ijin/Tugas Belajar</label>
                                        <div class="custom-file"> 
                                            <input type="file" name="fileIjinBelajar" class="custom-file-input" id="fileIjinBelajar" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File IB (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 ps-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf" id="btn_ijin_belajar" name="btn_ijin_belajar">Preview</a>
                                        {{-- </div> --}}
                                    </div> 
                                </div>
        
                                <div class="form-row mb-2">
                                    <div class="col-md-3" style="padding-right: 0; padding-left: 0;"> 
                                        <label for="customFile" >Uraian Tugas</label>
                                        <div class="custom-file">                          
                                            <input type="file" name="fileUraianTugas" class="custom-file-input" id="fileUraianTugas" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">Uraian Tugas (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 pe-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf" id="btn_uraian_tugas" name="btn_uraian_tugas">Preview</a>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-md-2 ps-0" style="padding-right: 0; padding-left: 0;">
                                        <label for="customFile" >PAK</label>
                                        <div class="custom-file"> 
                                            <input type="file" name="filePAK" class="custom-file-input" id="filePAK" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">File PAK (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Fungsional</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 ps-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf"  id="btn_pak" name="btn_pak">Preview</a>
                                        {{-- </div> --}}
                                    </div> 
                                    <div class="col-md-3" style="padding-right: 0; padding-left: 0;"> 
                                        <label for="customFile" >Akreditasi</label>
                                        <div class="custom-file">                          
                                            <input type="file" name="fileAkreditasi" class="custom-file-input" id="fileAkreditasi" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">Akreditasi (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                    </div>
                                    <div class="col-md mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 pe-0" style="padding-right: 0; padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf" id="btn_akreditasi" name="btn_akreditasi">Preview</a>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                               
                                <div class="form-row mb-2">
                                    
                                    <div class="col-md-3 ps-0" style="padding-right: 0;">
                                        <label for="customFile" >Forlap Dikti</label>
                                        <div class="custom-file"> 
                                            <input type="file" name="fileForlapDikti" class="custom-file-input" id="fileForlapDikti" accept=".pdf" accept=".pdf">
                                            <label class="custom-file-label" for="fileUraianTugas">Forlap Dikti (PDF)</label>
                                            <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small> 
                                        </div>
                                    </div>
                                    <div class="col-md-1 mg-sm-l-10 mg-t-10 mg-sm-t-25 pd-t-4 ps-0" style="padding-left: 0;">
                                        {{-- <div class="div"> --}}
                                            <a href="" class="btn btn-warning preview-pdf "  id="btn_forlap_dikti" name="btn_forlap_dikti">Preview</a>
                                        {{-- </div> --}}
                                    </div> 
                                </div>
        
                              {{-- </fieldset> --}}
                              {{-- akhir tab dok --}}
                        </div>
                      </div>                 
                    
                    {{-- <h4>Pelanggaran Akumulasi Tidak Dipatuhinya Jam Kerja</h4> --}}           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- modal lihat --}}

<div class="modal fade" id="lihatModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Lihat Data Usulan Kenaikan Pangkat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formLihat" enctype="multipart/form-data">
                {{-- @csrf
                @method('PUT') --}}
                <div class="modal-body">
                    {{-- id hidden --}}
                    <input type="hidden" name="id_usulan" id="id_usulan">
                    <ul class="nav nav-tabs nav-justified " id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active d-flex flex-column align-items-center" id="home-tab" data-toggle="tab" href="#homeLihat" role="tab" aria-controls="Data Usul" aria-selected="true">
                            <div class="nav-text">DATA USUL</div></a>
                        </li>
                        {{-- <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="Data Usul" aria-selected="true">DATA USUL</a>
                        </li> --}}
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profileLihat" role="tab" aria-controls="profile" aria-selected="false">DOKUMEN PERSYARATAN</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sk-tab" data-toggle="tab" href="#skLihat" role="tab" aria-controls="profile" aria-selected="false">Pertek/SK</a>
                        </li>
                    </ul>
                      <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                        <div class="tab-pane fade show active" id="homeLihat" role="tabpanel" aria-labelledby="home-tab">
                         

                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label class="form-label">NIP</label>
                                        <input type="text" id="nipLihat" name="nipLihat" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" id="namaLihat" name="namaLihat" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" id="jabatanLihat" name="jabatanLihat" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan Kerja</label>
                                        <input type="text" id="satkerLihat" name="satkerLihat" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 form-group">
                                    <div class="col-md-6">
                                        <label for="jenisKP">Jenis KP</label>
                                            <select name="jenisKPLihat" id="jenisKPLihat" class="form-control" readonly>
                                                <option value="1">Kenaikan Pangkat Reguler</option>
                                                <option value="2">Kenaikan Pangkat Struktural</option>
                                                <option value="3">Kenaikan Pangkat Memperoleh Ijazah</option>
                                                <option value="4">Kenaikan Pangkat Jabatan Fungsional</option>
                                            </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kelompokJabatan">Rumpun Jabatan</label>
                                            <select name="kelompokJabatanLihat" id="kelompokJabatanLihat" class="form-control" readonly>
                                                <option value="1">Hakim</option>
                                                <option value="2">Kepaniteraan/Kejurusitaan</option>
                                                <option value="3">Kesekretariatan</option>
                                            </select>
                                    </div>
                                </div>
                                {{--  batas isi tab biodata --}}

                        </div>
                        <div class="tab-pane fade" id="profileLihat" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="form-row"> 
                                    
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File SK KP</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" class="btn btn-sm btn-success preview-btn" id="btn_kpLihat" name="btn_kpLihat">Lihat File</button>
                                                    </div>
                                        
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File CPNS</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" class="btn btn-sm btn-success preview-btn" id="btn_cpnsLihat" name="btn_cpnsLihat">Lihat File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File Jabatan</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" id="btn_jabatanLihat" name="btn_jabatanLihat" class="btn btn-sm btn-success preview-btn">Lihat File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3"> 
                                                    <label for="customFile" >File SPP</label>
                                                    <div class="custom-file"> 
                                                        <button type="button" id="btn_sppLihat" name="btn_sppLihat" class="btn btn-sm btn-success preview-btn">Lihat File</button>
                                                    </div>
                                                </div>
                                   
                                </div>

                                
        
                                <div class="form-row">
                                    <div class="col-md-12">
                                        
                                        <div class="flat-accordion" id="accordion-wrapper">
                                            <!-- Accordion items akan ditambahkan oleh JS -->
                                            
                                        </div>

                                        
                                    </div>
                                </div>
                             
        
                              {{-- </fieldset> --}}
                              {{-- akhir tab dok --}}
                        </div>

                        {{-- tab File SK --}}
                        <div class="tab-pane fade" id="skLihat" role="tabpanel" aria-labelledby="SK-tab">
                    
                            <div class="form-row">
                                    <div class="col-md-12">
                                        {{-- <a href="" id="btn-pertek" name="btn-pertek" class="btn btn-primary btn-pertek"> liat Pertek</a>
                                        <input type="text" name="text-pertek" id="text-pertek"> --}}
                                        <div class="flat-accordion" id="accordion-wrapper-sk">
                                            <!-- Accordion items akan ditambahkan oleh JS -->
                                            
                                        </div>

                                        
                                    </div>
                                </div>
                            
                            
                        {{--  batas isi tab FIle SK --}}

                        </div>
                </div>                 
                    
                    {{-- <h4>Pelanggaran Akumulasi Tidak Dipatuhinya Jam Kerja</h4> --}}           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    {{-- <button type="submit" class="btn btn-primary">Simpan Perubahan</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal PDF --}}
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Preview PDF</h5>
            <a id="downloadLink" href="#" class="btn btn-success btn-sm ml-auto" target="_blank">
                Download PDF
            </a>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" style="height:80vh;">
            <div id="loadingSpinner" class="custom-loader">
                <span></span><span></span><span></span>
            </div>
          <iframe id="pdfFrame" width="100%" height="100%" style="border:none;"></iframe>
        </div>
      </div>
    </div>
</div>


<!-- Modal Validasi -->
<div class="modal fade" id="modalValidasi" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usulanModalLabel">Form Validasi Usulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formValidasi" name="formValidasi" enctype="multipart/form-data">
            @csrf
            @method('PUT')
          <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nipValidasi" name="nipValidasi" disabled>
          </div>
          
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="namaValidasi" name="namaValidasi" disabled>
          </div>
          
          <div class="mb-3">
            <label for="statusValidasi">Status Usulan</label>
            <select class="form-control" id="statusValidasi" name="statusValidasi" required>
              <option value="" selected disabled>Pilih Status Usulan</option>
              <option value="1">Diusulkan SIASN</option>
              <option value="2">Perbaikan</option>
              <option value="3">TTD Pertek</option>
              <option value="4">SK Telah Terbit</option>
              <option value="9">Tidak Dapat Diusulkan</option>
            </select>
            <div class="invalid-feedback">
              Harap pilih Status Usulan
            </div>
          </div>
          
          <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" rows="3" id="keteranganValidasi" name="keteranganValidasi"></textarea>
            <div class="invalid-feedback">
              Harap masukkan Catatan
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6">
                <label for="customFile" >File Pertek BKN</label>
                <div class="custom-file"> 
                    <input type="file" name="filePertek" class="custom-file-input" id="filePertek" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileUraianTugas">file Pertek (PDF)</label>
                    <small class="text-muted">Maksimal 2MB, format PDF</small>
                </div>
            </div>
            <div class="col-md-6">
                <label for="customFile" >File SK</label>
                <div class="custom-file"> 
                    <input type="file" name="fileSK" class="custom-file-input" id="fileSK" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileSK">file SK (PDF)</label>
                    <small class="text-muted">Maksimal 2MB, format PDF</small>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="btnSimpanValidasi" id="btnSimpanValidasi">Simpan Perubahan</button>
                </div>
    </form>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Menampilkan spinner load halaman
     document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('spinner').style.display = 'flex';
        });

    // Sembunyikan saat semua resource selesai load
    window.addEventListener('load', function() {
        document.getElementById('spinner').style.display = 'none';
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

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


        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
            // tombol edit
            $(document).ready(function() {
            // Tombol Edit diklik
            $('#tabel').on('click', '.btn-edit', function() {
            var id = $(this).data('id');
                // console.log(id)
                // kosongkan dulu value button
                $('#nip').val('');
                $('#nama').val('');
                $('#jabatan').val('');
                $('#satker').val('');
                $('#jenisKP').val('');
                $('#kelompokJabatan').val('');
    
                $('#btn_skp1').removeAttr('data-url');
                $('#btn_skp2').removeAttr('data-url');
                $('#btn_pak').removeAttr('data-url');
                $('#btn_akreditasi').removeAttr('data-url');
                $('#btn_forlap_dikti').removeAttr('data-url');
                $('#btn_stlud').removeAttr('data-url');
                $('#btn_ijin_belajar').removeAttr('data-url');
                $('#btn_uraian_tugas').removeAttr('data-url');
                // $('#btn_ijazah').removeAttr('data-url');
                $('#btn_ijazah').attr('href','');
                $('#btn_transkrip').removeAttr('data-url');
                $('#id_usulan').val('');

                // $('#isi_ijazah').val('');


                $.get("{{ url('usulkp') }}/" + id + "/edit", function(data) {
                    $('#editForm').attr('action', "{{ url('usulkp') }}/" + id);
                    $('#nip').val(data.nip);
                    $('#id_usulan').val(data.id);
                    // $('#id_usulan').val("{{ url('usulkp') }}/" + id);
                    $('#nama').val(data.nama);
                    $('#jabatan').val(data.jabatan);
                    $('#satker').val(data.satker);
                    $('#jenisKP').val(data.jenis_kp);
                    $('#kelompokJabatan').val(data.kategori_jabatan);
                    $('#btn_kp').attr('data-url',data.file_kp_terakhir);
                    $('#btn_jabatan').attr('data-url',data.file_jabatan_terakhir);
                    $('#btn_spp').attr('data-url',data.file_spp);
                    $('#btn_cpns').attr('data-url',data.file_cpns);
                    $('#btn_skp1').prop('href','/storage/' + data.file_skp1);
                    $('#btn_skp2').prop('href','/storage/' + data.file_skp2);
                    $('#btn_pak').prop('href','/storage/' + data.file_pak);
                    $('#btn_akreditasi').prop('href','/storage/' + data.file_akreditasi);
                    $('#btn_forlap_dikti').prop('href','/storage/' + data.file_forlap_dikti);
                    $('#btn_stlud').prop('href','/storage/' + data.file_stlud);
                    
                    $('#btn_ijin_belajar').prop('href','/storage/' + data.file_ijin_belajar);
                    $('#btn_uraian_tugas').prop('href','/storage/' + data.file_uraian_tugas);
                    // $('#btn_ijazah').attr('data-url','/storage/' + data.file_ijazah);
                    
                    $('#btn_ijazah').prop('href','/storage/' + data.file_ijazah);
                    // $('#isi_ijazah').val('/storage/' + data.file_ijazah);
                    $('#btn_transkrip').prop('href','/storage/' + data.file_transkrip);


                    $(document).ready(function() {
                        $('a').each(function() {
                            var href = $(this).attr('href');
                            if (href && href.toLowerCase().includes('/storage/null')) {
                                // Nonaktifkan link jika mengandung /storage/null
                                $(this).addClass('disabled')
                                    .css({
                                        'pointer-events': 'none',
                                        'cursor': 'not-allowed',
                                        'opacity': '0.6'
                                    })
                                    .attr('tabindex', '-1')
                                    .attr('aria-disabled', 'true');
                            } else {
                                // Aktifkan kembali link jika tidak mengandung /storage/null
                                $(this).removeClass('disabled')
                                    .css({
                                        'pointer-events': 'auto',
                                        'cursor': 'pointer',
                                        'opacity': '1'
                                    })
                                    .removeAttr('tabindex')
                                    .attr('aria-disabled', 'false');
                            }
                        });
                    });
               
                    
                    $('#editModal').modal('show');
                });
            });

           


        // preview pdf yang berasal dari file server
        $(document).ready(function () {
        $('.preview-pdf').on('click', function (e) {
            e.preventDefault();

            // var pdfUrl = $(this).data('url');
            var pdfUrl = $(this).attr('href') || $(this).data('url');

            $('#pdfFrame').attr('src', pdfUrl);
            $('#loadingSpinner').show();
            $('#downloadLink').attr('href', pdfUrl);
            $('#pdfModal').modal('show');
        });

        // Saat iframe selesai load, sembunyikan spinner
        $('#pdfFrame').on('load', function() {
            $('#loadingSpinner').fadeOut();
            $(this).fadeIn();
        });

        // Opsional: reset iframe & link saat modal ditutup
        $('#pdfModal').on('hidden.bs.modal', function () {
            $('#pdfFrame').attr('src', '');
            $('#downloadLink').attr('href', '#');
        });

        });

// tombol lihat pdf sikep
    $(document).ready(function() {
        $('.preview-btn').on('click', function() {
            var fileUrl = $(this).data('url');
            var encodedUrl = encodeURIComponent(fileUrl);
            var proxyUrl = '/preview-pdf-direct?url=' + encodedUrl;

            // Tampilkan spinner, sembunyikan iframe
            $('#loadingSpinner').show();
            $('#pdfFrame').hide().attr('src', proxyUrl);
            $('#downloadLink').attr('href', proxyUrl);
            $('#pdfModal').modal('show');
        });

         // Saat iframe selesai load, sembunyikan spinner
         $('#pdfFrame').on('load', function() {
            $('#loadingSpinner').fadeOut();
            $(this).fadeIn();
        });

        // Opsional: reset iframe & link saat modal ditutup
        $('#pdfModal').on('hidden.bs.modal', function () {
            $('#pdfFrame').attr('src', '');
            $('#downloadLink').attr('href', '#');
        });
    });

   
    
    });


    $('#editForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            
            // Buat FormData object untuk handle file upload
            var formData = new FormData(this);
            formData.append('_method', 'PUT'); // Tambahkan method override
            
            // Tampilkan loading
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,  // Penting untuk FormData
                contentType: false,  // Penting untuk FormData
                success: function(response) {
                    $('#editModal').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON?.message || 
                                    (xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).join('<br>') : 'Terjadi kesalahan. Silakan coba lagi.');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                        footer: 'Status: ' + xhr.status + ' ' + xhr.statusText
                    });
                },
                complete: function() {
                    // Reset tombol submit
                    form.find('button[type="submit"]').prop('disabled', false).html('Simpan Perubahan');
                }
            });
        });
    



            $(document).ready(function() {
                // Fungsi copy NIP dengan Swal
                $(document).on('click', '.btn-copy-nip', function() {
                    const nip = $(this).siblings('.nip-text').text().trim();
                    const button = $(this);
                    
                    // Simpan HTML asli untuk dikembalikan nanti
                    const originalHtml = button.html();
                    
                    // Buat elemen textarea untuk copy
                    const $temp = $('<textarea>');
                    $('body').append($temp);
                    $temp.val(nip).select();
                    
                    try {
                    // Coba menggunakan Clipboard API modern
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(nip).then(function() {
                        showSuccessAlert(button, originalHtml);
                        }).catch(function() {
                        fallbackCopy();
                        });
                    } else {
                        // Fallback untuk browser lama
                        fallbackCopy();
                    }
                    } catch (err) {
                    console.error('Gagal menyalin NIP:', err);
                    showErrorAlert();
                    } finally {
                    $temp.remove();
                    }
                    
                    function fallbackCopy() {
                    const success = document.execCommand('copy');
                    if (success) {
                        showSuccessAlert(button, originalHtml);
                    } else {
                        showErrorAlert();
                    }
                    }
                });

                // Tampilkan alert sukses
                function showSuccessAlert(button, originalHtml) {
                    // Ubah tampilan tombol sementara
                    button.html('<i class="fas fa-check"></i> Tersalin!').css('background', '#28a745').css('color', 'white');
                    
                    // Tampilkan SweetAlert
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'NIP berhasil disalin',
                    text: 'NIP telah disalin ke clipboard',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                    });
                    
                    // Kembalikan tampilan tombol setelah 2 detik
                    setTimeout(function() {
                    button.html(originalHtml).css('background', '').css('color', '');
                    }, 2000);
                }
                
                // Tampilkan alert error
                function showErrorAlert() {
                    Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menyalin NIP',
                    });
                }
                });



            // tombol lihat
            
            // $('.btn-lihat').click(function() {
            $('#tabel').on('click', '.btn-lihat', function() {   
            var id = $(this).data('id');
                // console.log(id)
                // kosongkan dulu value button
                $('#nip').val('');
                $('#nama').val('');
                $('#jabatan').val('');
                $('#satker').val('');
                $('#jenisKP').val('');
                $('#kelompokJabatan').val('');
    
                $('#btn_skp1').removeAttr('data-url');
                $('#btn_skp2').removeAttr('data-url');
                $('#btn_pak').removeAttr('data-url');
                $('#btn_akreditasi').removeAttr('data-url');
                $('#btn_forlap_dikti').removeAttr('data-url');
                $('#btn_stlud').removeAttr('data-url');
                $('#btn_ijin_belajar').removeAttr('data-url');
                $('#btn_uraian_tugas').removeAttr('data-url');
                // $('#btn_ijazah').removeAttr('data-url');
                $('#btn_ijazah').attr('href','');
                $('#btn_transkrip').removeAttr('data-url');
                $('#id_usulan').val('');

                // $('#isi_ijazah').val('');


                $.get("{{ url('usulkp') }}/" + id + "/edit", function(data) {
                    $('#formLihat').attr('action', "{{ url('usulkp') }}/" + id);
                    $('#nipLihat').val(data.nip);
                    // $('#id_usulanLihat').val(data.id);
                    // $('#id_usulan').val("{{ url('usulkp') }}/" + id);
                    // console.log(data.nama);
                    $('#namaLihat').val(data.nama);
                    $('#jabatanLihat').val(data.jabatan);
                    $('#satkerLihat').val(data.satker);
                    $('#jenisKPLihat').val(data.jenis_kp);
                    $('#kelompokJabatanLihat').val(data.kategori_jabatan);
                    $('#btn_kpLihat').attr('data-url',data.file_kp_terakhir);
                    $('#btn_jabatanLihat').attr('data-url',data.file_jabatan_terakhir);
                    $('#btn_sppLihat').attr('data-url',data.file_spp);
                    $('#btn_cpnsLihat').attr('data-url',data.file_cpns);
                    $('#btn_skp1Lihat').prop('href','/storage/' + data.file_skp1);
                    $('#btn_skp2Lihat').prop('href','/storage/' + data.file_skp2);
                    $('#btn_pakLihat').prop('href','/storage/' + data.file_pak);
                    $('#btn_akreditasiLihat').prop('href','/storage/' + data.file_akreditasi);
                    $('#btn_forlap_diktiLihat').prop('href','/storage/' + data.file_forlap_dikti);
                    $('#btn_stludLihat').prop('href','/storage/' + data.file_stlud);
                    
                    $('#btn_ijin_belajarLihat').prop('href','/storage/' + data.file_ijin_belajar);
                    $('#btn_uraian_tugasLihat').prop('href','/storage/' + data.file_uraian_tugas);
                    // $('#btn_ijazah').attr('data-url','/storage/' + data.file_ijazah);
                    
                    $('#btn_ijazahLihat').prop('href','/storage/' + data.file_ijazah);
                    // $('#isi_ijazah').val('/storage/' + data.file_ijazah);
                    $('#btn_transkripLihat').prop('href','/storage/' + data.file_transkrip);
                    // $('#btn-pertek').prop('href','/storage/' + data.file_pertek);
                    // $('#text-pertek').val('/storage/' + data.file_pertek);



                    // accordian
                    $('#frameSKP1').prop('src','/storage/' + data.file_skp1);
                    $('#frameSKP2').prop('src','/storage/' + data.file_skp2);

                    $('#framePAK').prop('src','/storage/' + data.file_pak);
                    $('#frameAkreditasi').prop('src','/storage/' + data.file_akreditasi);
                    $('#frameForlapDikti').prop('src','/storage/' + data.file_forlap_dikti);
                    $('#frameSTLUD').prop('src','/storage/' + data.file_stlud);
                    
                    $('#frameIjinBelajar').prop('src','/storage/' + data.file_ijin_belajar);
                    // $('#frameUraianTugas').prop('src','/storage/' + data.file_ijin_belajar);
                    $('#frameUraianTugas').prop('src','/storage/' + data.file_uraian_tugas);
                    // $('#btn_ijazah').attr('data-url','/storage/' + data.file_ijazah);
                    
                    $('#frameIjazah').prop('src','/storage/' + data.file_ijazah);
                    // $('#isi_ijazah').val('/storage/' + data.file_ijazah);
                    $('#frameTranskrip').prop('src','/storage/' + data.file_transkrip);


                    $(document).ready(function() {
                        $('a').each(function() {
                            var href = $(this).attr('href');
                            if (href && href.toLowerCase().includes('/storage/null')) {
                                // Nonaktifkan link jika mengandung /storage/null
                                $(this).addClass('disabled')
                                    .css({
                                        'pointer-events': 'none',
                                        'cursor': 'not-allowed',
                                        'opacity': '0.6'
                                    })
                                    .attr('tabindex', '-1')
                                    .attr('aria-disabled', 'true');
                            } else {
                                // Aktifkan kembali link jika tidak mengandung /storage/null
                                $(this).removeClass('disabled')
                                    .css({
                                        'pointer-events': 'auto',
                                        'cursor': 'pointer',
                                        'opacity': '1'
                                    })
                                    .removeAttr('tabindex')
                                    .attr('aria-disabled', 'false');
                            }
                        });
                    });

                     const fileList = [
    
                    { label: 'File SKP 1', file: data.file_skp1 },
                    { label: 'File SKP 2', file: data.file_skp2 },
                    { label: 'File PAK', file: data.file_pak },
                    { label: 'File Akreditasi', file: data.file_akreditasi },
                    { label: 'File Forlap Dikti', file: data.file_forlap_dikti },
                    { label: 'File STLUD', file: data.file_stlud },
                    { label: 'File Ijin Belajar', file: data.file_ijin_belajar },
                    { label: 'File Uraian Tugas', file: data.file_uraian_tugas },
                    { label: 'File Ijazah', file: data.file_ijazah },
                    { label: 'File Transkrip', file: data.file_transkrip },
                    // { label: 'File Pertek', file: data.file_pertek},
                    // { label: 'File SK', file: data.file_sk_siasn},
                ];

                const fileListSK = [
                    {label: 'File Pertek', file: data.file_pertek},
                    {label: 'File SK', file: data.file_sk_siasn},
                ];

                // Kosongkan accordion-wrapper agar tidak dobel saat buka ulang
                $('#accordion-wrapper').empty();
                $('#accordion-wrapper-sk').empty();

                fileList.forEach(function(item, index) {
                    if (item.file && !item.file.includes('storage/null')) {
                        $('#accordion-wrapper').append(`
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <span class="accordion-title">${item.label}</span>
                                    <i class="fas fa-chevron-down accordion-icon"></i>
                                </div>
                                <div class="accordion-content" style="display: none;">
                                    <iframe src="/storage/${item.file}" class="pdf-viewer" name ="frameitem${item.file}" id= "frameitem${item.file}" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                </div>
                            </div>
                        `);

                    }
                });

                fileListSK.forEach(function(item, index) {
                    if (item.file && !item.file.includes('storage/null')) {
                        $('#accordion-wrapper-sk').append(`
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <span class="accordion-title">${item.label}</span>
                                    <i class="fas fa-chevron-down accordion-icon"></i>
                                </div>
                                <div class="accordion-content" style="display: none;">
                                    <iframe src="/storage/${item.file}" class="pdf-viewer" name ="frameitem${item.file}" id= "frameitem${item.file}" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                </div>
                            </div>
                        `);

                    }
                });

                    $('#lihatModal').modal('show');
                });
            });
            
            // akhir tombol lihat

            // Pasang ulang event handler setelah semua item accordian pdf 
            $('#accordion-wrapper').on('click', '.accordion-header', function() {
                const $accordionContent = $(this).next('.accordion-content');
                const $icon = $(this).find('i');

                // Toggle current item
                $accordionContent.slideToggle(200);
                $icon.css('transform', $accordionContent.is(':visible') ? 'rotate(180deg)' : 'rotate(0)');

                // Close other items
                $('.accordion-content').not($accordionContent).slideUp(200);
                $('.accordion-header i').not($icon).css('transform', 'rotate(0)');
            });

            $('#accordion-wrapper-sk').on('click', '.accordion-header', function() {
                const $accordionContent = $(this).next('.accordion-content');
                const $icon = $(this).find('i');

                // Toggle current item
                $accordionContent.slideToggle(200);
                $icon.css('transform', $accordionContent.is(':visible') ? 'rotate(180deg)' : 'rotate(0)');

                // Close other items
                $('.accordion-content').not($accordionContent).slideUp(200);
                $('.accordion-header i').not($icon).css('transform', 'rotate(0)');
            });
   

   //click tombol validasi
   $(document).ready(function(){
        $('#tabel').on('click', '.btn-validasi', function() {
            var id = $(this).data('id');
            $('#namaValidasi').val('');
            $('#nipValidasi').val('');

            $.get("{{ url('usulkp') }}/" + id + "/edit", function(data) {
                    $('#formValidasi').attr('action', "{{ url('usulkp-validasi') }}/" + id);
                    $('#nipValidasi').val(data.nip);
                    $('#namaValidasi').val(data.nama);
                    $('#id_usulan').val(data.id);
            });

            $('#modalValidasi').modal('show');
        });
   });  
   
   
   


         $('#formValidasi').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            
            // Buat FormData object untuk handle file upload
            var formData = new FormData(this);
            formData.append('_method', 'PUT'); // Tambahkan method override
            
            // Tampilkan loading
            // console.log('Set button loading...');
            // $(this).find('button[type="button"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            $('#btnSimpanValidasi').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
           
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,  // Penting untuk FormData
                contentType: false,  // Penting untuk FormData
                success: function(response) {
                    $('#modalValidasi').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON?.message || 
                                    (xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).join('<br>') : 'Terjadi kesalahan. Silakan coba lagi.');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                        footer: 'Status: ' + xhr.status + ' ' + xhr.statusText
                    });
                },
                complete: function() {
                    // Reset tombol submit
                    // form.find('button[type="submit"]').prop('disabled', false).html('Simpan Perubahan');
                     $('#btnSimpanValidasi').prop('disabled', false).html('Simpan Perubahan');
                }
            });
        });

       
    </script>

@endsection
