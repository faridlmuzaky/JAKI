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
          <a href="{{url('/addizbel')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Usulan</a>
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
            <h6 class="mg-b-5">Daftar Permohonan Izin Belajar</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Permohonan izin belajar yang telah diinput.</p>
     
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <table class="table mt-3" id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Universitas</th>
                        <th scope="col">Tanggal Pengajuan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @foreach ($Izbel as $item)   
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <a href="/izbel/{{$item->id}}/detail">{{$item->nama_pegawai}}</a>
                            <br>{{$item->nip}}
                        </td>
                        <td>{{$item->jabatan}}</td>
                        <td>{{$item->nama_universitas}}</td>
                        <td>{{$item->created_at->isoFormat('D MMMM Y')}}
                          <br>Status : <b @if ($item->status=='Pengajuan Awal')
                            class="badge badge-info"
                          @endif 
                          @if ($item->status=='Perbaikan')
                              class="badge badge-warning"
                          @endif
                          @if ($item->status=='Ditolak')
                              class="badge badge-danger"
                          @endif
                          @if ($item->status=='Diterima')
                              class="badge badge-primary"
                          @endif
                          @if ($item->status=='Dikunci')
                              class="badge badge-success"
                          @endif
                          >{{$item->status}}</b>
                          <br>Keterangan : {{$item->keterangan}}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i data-feather="list"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="/izbel/{{$item->id}}/edit">Edit</a>
                                  <a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal{{$item->id}}">Delete</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="/izbel/{{$item->id}}/historyuser"><i data-feather="clock" class="wd-15 mg-r-5"></i>History Usulan</a>
                                  <a class="dropdown-item" href="/izbel/{{$item->id}}/waizbel"><i data-feather="send" class="wd-15 mg-r-5"></i>Kirim Whatsapp</a>
                                  @if ($item->produk != '')
                                  <a class="dropdown-item" href="{{asset('images').'/'.$item->produk}}"><i data-feather="download" class="wd-15 mg-r-5"></i>Download SK Izin</a>   
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

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> --}}
    @foreach ($Izbel as $item) 
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
            <br> {{$item->nama_pegawai}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="/izbel/{{$item->id}}/delete"  class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
@endsection