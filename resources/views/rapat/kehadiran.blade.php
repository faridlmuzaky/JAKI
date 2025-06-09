@extends('layout.main')
@section('title', 'Kehadiran Rapat')

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
                            <li class="breadcrumb-item"><a href="#">Rapat</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Hadir </li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Daftar Hadir Rapat</h4>
                </div>
                <div class="d-flex justify-content-end">
                    {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
                    {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
                    <a href="{{ url('/rapat') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i
                            data-feather="chevrons-left" class="wd-10 mg-r-5"></i> Kembali</a>
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
                        <h6 class="mg-b-5">{{ $rapat->deskripsi }}</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">{{ date('j M Y', strtotime($rapat->tgl_rapat)) . ' - ' . $rapat->time_in }}</p>
                    </div><!-- card-header -->
                    <form method="POST" action="/undanganrapat" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <input type="text" value="{{ $id }}" name="id_rapat" hidden>
                        <div class="table-responsive">
                            <div class="card-body pd-20">
                                <table class="table mt-3" id="tabel1">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NIP/NIK</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Kehadiran</th>
                                            <th scope="col">Tanda Tangan</th>
                                        </tr>
                                    </thead>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            {{-- <td>{{ ($item->date_in ? date('j M Y', strtotime($item->date_in)) : '') . ' - ' . $item->time_in }} --}}
                                            <td>{{ $item->date_in . ' - ' . $item->time_in }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </form>

                </div><!-- card-body -->
            </div><!-- card -->
        </div>

    </div><!-- container -->
    </div>
    </div><!-- content -->

    {{-- <script src="{{ asset('style/dashforge')}}/lib/select2/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
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
    </script>

    <script type="text/javascript">
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        (function() {
            $('.needs-validation').on('submit', function() {
                $('.btn-success').attr('disabled', 'true');
                $('.spinner').show();
                $('.hide-text').hide();
            })
        })();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#namabaru').select2({
                placeholder: 'Silahkan Pilih',
                searchInputPlaceholder: 'Search options'

            });

        });
        // In your Javascript (external .js resource or <script> tag)
    </script>

    <script>
        $(document).ready(function() {
            $('#tabel1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

@endsection
