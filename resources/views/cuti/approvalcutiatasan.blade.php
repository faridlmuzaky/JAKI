@extends('layout.main')
@section('title', 'Approval Cuti')

@section('content')
<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Persetujuan Atasan Langsung Usul Cuti</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Persetujuan Atasan Langsung Usul Cuti</h4>
        </div>
        <div class="d-none d-md-block">
          
        </form>
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
            <h6 class="mg-b-5">Permohonan Cuti</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Permohonan cuti yang telah diinput.</p>
     
          </div><!-- card-header -->
          <div class="table-responsive">
          <div class="card-body pd-20">
            <table class="table mt-3" id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Satker</th>
                        <th scope="col">Tahun</th>
                        <th scope="col" class="text-center">Lama Cuti (Hari)</th>
                        <th scope="col" class="text-center">Catatan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @foreach ($cuti as $item)   
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <a href="#">{{$item->nama}}</a>
                            <br>{{$item->nip}}
                        </td>
                        <td>{{$item->jabatan}}</td>
                        <td>{{$item->nama_satker}}</td>
                        <td>{{$item->tahun_anggaran}}</td>
                        <td class="text-center">{{$item->lama_cuti." hari"}}</td>
                        <td class="text-center">Tgl cuti : {{  date('j F Y',strtotime($item->tgl_mulai))}} s.d {{  date('j F Y',strtotime($item->tgl_akhir))}}
                          <br>Status : <b @if ($item->status=='Usulan Baru')
                            class="badge badge-primary"
                            @endif 
                            @if ($item->status=='Persetujuan Atasan')
                                class="badge badge-warning"
                            @endif
                            @if ($item->status=='Persetujuan Ketua')
                                class="badge badge-info"
                            @endif
                            @if ($item->status=='Ditolak')
                                class="badge badge-danger"
                            @endif
                            @if ($item->status=='Tidak Disetujui')
                                class="badge badge-danger"
                            @endif
                            @if ($item->status=='Disetujui')
                                class="badge badge-success"
                            @endif
                            @if ($item->status=='Ditangguhkan')
                                class="badge badge-danger"
                            @endif
                          {{-- @if ($item->status=='Dikunci')
                              class="badge badge-success"
                          @endif --}}
                          >{{$item->status}}</b>
                          {{-- <br>Keterangan : {{$item->keterangan}} --}}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i data-feather="list"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  
                                  <div class="dropdown-divider"></div>
                                  
                                  <a class="dropdown-item" href="/approvalcutiatasandetail/{{$item->id_detail}}/proses"><i data-feather="check-square" class="wd-15 mg-r-5"></i>Proses</a>
                                
                                  {{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal{{$item->id_detail}}"><i data-feather="edit" class="wd-15 mg-r-5"></i>Proses Atasan</a> --}}
                                  <div class="dropdown-divider"></div>
                                  {{-- <a class="dropdown-item" href="/izbel/{{$item->id}}/historyuser"><i data-feather="clock" class="wd-15 mg-r-5"></i>History Usulan</a> --}}
                                  {{-- <a class="dropdown-item" href="/izbel/{{$item->id_detail}}/waizbel"><i data-feather="send" class="wd-15 mg-r-5"></i>Kirim Whatsapp</a> --}}
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

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> --}}
    @foreach ($cuti as $item) 
    <!-- Modal -->
    <div class="modal fade" id="Modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Izin Belajar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah yakin akan menghapus data ini?
            {{-- <br> {{$item->nama_pegawai}} --}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="/izbel/{{$item->id}}/delete"  class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach

     {{-- modal jenis cuti --}}
     <div class="modal fade" id="ModalCuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Cuti</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form action="{{url('/addusulct')}}" method="POST">
              @csrf
              <div class="modal-body">
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Cuti</label>
                    <div class="col-sm-9">
                      <select class="custom-select" name="jenis">
                        <option selected disabled>- Pilih Jenis Cuti -</option>
                        <option value="Cuti Tahunan">Cuti Tahunan</option>
                        <option value="Cuti Besar">Cuti Besar </option>
                        <option value="Cuti Sakit">Cuti Sakit</option>
                        <option value="Cuti Bersalin">Cuti Bersalin</option>
                        <option value="Cuti Alasan Penting">Cuti Alasan Penting</option>
                        <option value="CTLN">CTLN</option>
                      </select>
                    </div>
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah</button>
              </div>
            </form>
        </div>
      </div>
    </div>

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
    </script>
    {{-- Akhir Add Cuti --}}
@endsection