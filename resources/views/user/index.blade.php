@extends('layout.main')
@section('title', 'User Management')

@section('content')
<div class="content-body">
   {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Management</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Welcome to User Management</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/adduser')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i> Add New User</a>
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
            <h6 class="mg-b-5">List of Users</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Daftar User Aplikasi Kinerja Kita.</p>
     
          </div><!-- card-header -->
          <div class="table-responsive">
          <div class="card-body pd-20">
            <table class="table mt-3" id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Usename</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Telepon/WA</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @foreach ($data as $item)   
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="/user/{{$item->id}}/profile">{{$item->name}}</a></td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->jabatan}}</td>
                        <td>{{$item->telp}}</td>
                        <td>{{$item->created_at->isoFormat('D MMMM Y HH:mm:ss')}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i data-feather="list"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="/user/{{$item->id}}/edit">Edit</a>
                                  <a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal{{$item->id}}">Delete</a>
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
    @foreach ($data as $item) 
    <!-- Modal -->
    <div class="modal fade" id="Modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah yakin akan menghapus data ini?
            <br> {{$item->name}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="/user/{{$item->id}}/delete"  class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach

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
@endsection