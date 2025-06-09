@extends('layout.main')
@section('title', 'Daftar Pegawai')

@section('content')
<style>
  /* untuk menghilangkan spinner  */
  .spinner {
      display: none;
  }

</style>


{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}


<div class="content-body">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Peserta Rapat </li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Daftar Peserta Rapat</h4>
        </div>
        <div class="d-flex justify-content-end">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          <a href="{{url('/rapat')}}"  class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="chevrons-left" class="wd-10 mg-r-5"></i> Kembali</a>
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
            <h6 class="mg-b-5">Daftar Peserta Rapat</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Daftar Peserta Rapat</p>
     
            <a href=""  class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5 mt-3" data-toggle="modal" data-target="#ModalTambah"><i data-feather="users" class="wd-10 mg-r-5"></i><i data-feather="plus" class="wd-10 mg-r-5"></i> Tambah Peserta</a>
          </div><!-- card-header -->
          <form method="POST" action="/undanganrapat" class="needs-validation" enctype="multipart/form-data">
                
            @csrf
            <input type="text" value="{{$id}}" name="id_rapat" hidden>
          <div class="table-responsive">
          <div class="card-body pd-20">
            <table class="table mt-3" id="tabel1">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIP/NIK</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">No HP</th>
                        <th scope="col"></th>
                        <th scope="col"><input type="checkbox" name="chk[]" onchange="checkAll(this)"></th>
                    </tr>
                </thead>
                @foreach ($data as $item)   
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        {{$item->user}}</>
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->jabatan}}</td> 
                    <td>{{$item->telp}}</td> 
                    <td><a href="" class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 " data-toggle="modal" data-target="#ModalHapus{{$item->user}}"><i data-feather="trash"></i></a></td> 
                    <td>
                        <input type="checkbox" name="chk[]" value="{{$item->telp}}">
                    </td>
                </tr>
            @endforeach
               
            </table>
            {{-- <button type="submit" class="btn btn-success"><i data-feather="send" class="wd-20 mg-r-5"></i>Kirim WA Undangan</button> --}}

            {{-- <button type="submit" class="btn btn-success">
              <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Sedang mengirim</div>
              <div class="hide-text">
                <i data-feather="send" class="wd-20 mg-r-5"></i>Kirim WA Undangan
              </div>
            </button> --}}

            <li class="list-group-item d-flex justify-content-between ">
              <button type="submit" class="btn btn-success">
                <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Sedang mengirimkan pesan</div>
                <div class="hide-text">
                  <i data-feather="send" class="wd-20 mg-r-5"></i> Kirim Undangan via Whatsapp
                </div>
              </button>
          </form>

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


{{-- Modal Hapus --}}

<!-- Modal -->
@foreach ($data as $item)
    <div class="modal fade" id="ModalHapus{{$item->user}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" action="{{ url('/hapuspeserta/'.$item->user) }}" class="needs-validation" enctype="multipart/form-data">
          @csrf
        <input type="text" value="{{$id}}" name="id_rapat2" hidden>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Peserta Rapat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          Yakim akan menghapus peserta ini ?
          <br> {{$item->user}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </div>
      </form>
      </div>
    </div>
@endforeach




<!-- Modal -->
<div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ url('/simpanpesertabaru') }}" class="needs-validation" enctype="multipart/form-data">
      @csrf
    <input type="text" value="{{$id}}" name="id_rapat1" hidden>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Peserta Rapat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $activeuser = DB::table('peserta_rapat')
                  ->select('user')
                  ->where('id_rapat',$id);

        $user = DB::table('users')
          ->wherenotIn('username',$activeuser)
          ->where('satker_id',Auth::user()->satker_id)
          ->get();
        ?>

        {{-- <label for="namabaru">Nama Pegawai --}}
          <select class="form-control js-states" id="namabaru" name="namabaru[]" multiple="multiple" style="width: 100%">
            @foreach ($user as $item)
            <option value="{{$item->username}}">{{$item->name}}</option>
            @endforeach
          </select>
        {{-- </label> --}}
        
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Simpan</button>
      </div>
    </div>
  </form>
  </div>
</div>

{{-- <script src="{{ asset('style/dashforge')}}/lib/select2/js/select2.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
  function checkAll(ele) {
       var checkboxes = document.getElementsByTagName('input');
       if (ele.checked) {
           for (var i = 0; i < checkboxes.length; i++) {
               if (checkboxes[i].type == 'checkbox' ) {
                   checkboxes[i].checked = true;
               }
           }
       } else {
           for (var i = 0; i < checkboxes.length; i++) {
               if (checkboxes[i].type == 'checkbox') {
                   checkboxes[i].checked = false;
               }
           }
       }
   }
 </script>

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

<script type="text/javascript">

  $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

  (function () {
          $('.needs-validation').on('submit', function () {
              $('.btn-success').attr('disabled', 'true');
              $('.spinner').show();
              $('.hide-text').hide();
          })
      })();

</script>

<script type="text/javascript">
  
  $(document).ready(function(){
    $('#namabaru').select2({
      placeholder: 'Silahkan Pilih',
      searchInputPlaceholder: 'Search options'

    });

  });


// In your Javascript (external .js resource or <script> tag)
</script>

@endsection