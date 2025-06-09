@extends('layout.main')
@section('title', 'Dashboard')

@section('content')

<div class="content-body">
    {{-- <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0"> --}}
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">kinerja-KITA</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Selamat Datang</h4>
        </div>
        <div class="d-none d-md-block">
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button> --}}
          {{-- <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="plus" class="wd-10 mg-r-5"></i> Add New Ticket</button> --}}
        </div>
      </div>
      
      {{-- Main Content  --}}
      @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
      @endif


        {{-- card --}}
        <div class="row row-xs">
              <div class="col-sm-6 col-lg-3">
                        <div class="card card-body ht-lg-100">
                          <div class="media">
                            <i data-feather="calendar" class="wd-60 ht-60"></i>
                            <div class="media-body mg-l-20">
                              <h6 class="mg-b-10">Usul Cuti</h6>
                         
                              <a href="{{url('/cutiuser')}}" class="btn btn-xs btn-primary">Lihat detail</a>
                            </div>
                          </div>
                        </div>
              </div>
                      <div class="col-sm-6 col-lg-3">
                        <div class="card card-body ht-lg-100">
                          <div class="media">               
                            <i data-feather="mail" class="wd-60 ht-60"></i>
                            <div class="media-body mg-l-20">
                              <h6 class="mg-b-10">Surat Masuk</h6>
                              <a href="#" class="btn btn-xs btn-primary">Lihat detail</a>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                
          </div>
           
        
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                  <div>
                    <h6 class="mg-b-5">Histori Cuti {{Auth::User()->name}}</h6>
                    <p class="tx-13 tx-color-03 mg-b-0">Informasi cuti yang diajukan pada tahun berjalan</p>
                  </div>
                  {{-- <div class="d-flex mg-t-20 mg-sm-t-0">
                    <div class="btn-group flex-fill">
                      <button class="btn btn-white btn-xs active">Range</button>
                      <button class="btn btn-white btn-xs">Period</button>
                    </div>
                  </div> --}}
                </div><!-- card-header -->
                <div class="card-body pd-y-30">
                  <div class="d-sm-flex">
                    <div class="media">
                      <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                      </div>
                      <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Usulan Cuti Bulan Ini</h6>
                        <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$ctbln}}</h4>
                      </div>
                    </div>
                    <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                      <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                      </div>
                      <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Usulan Cuti Tahun Ini</h6>
                        <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{$ctthn}}</h4>
                      </div>
                    </div>
                    {{-- <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                      <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                      </div>
                      <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Net Earnings</h6>
                        <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">$1,608,469<small>.50</small></h4>
                      </div>
                    </div> --}}
                  </div>
                </div><!-- card-body -->
                <div class="table-responsive">
                  <table class="table table-dashboard mg-b-0">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th class="text-center">Tanggal Cuti</th>
                        <th class="text-center">Jenis Cuti</th>
                        <th class="text-center">Alasan Cuti</th>
                        <th class="text-center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($cuti as $item) 
                      <tr>
                        <td class="tx-color-03 tx-normal">{{$loop->iteration}}</td>
                        <td class="tx-medium text-center">{{  date('d M Y',strtotime($item->tgl_mulai))}} s.d {{  date('d M Y',strtotime($item->tgl_akhir))}}</td>
                        <td class="text-center text-primary">{{$item->jenis_cuti}}</td>
                        <td class="text-center tx-pink">{{$item->alasan_cuti}}</td>
                        <td class="tx-medium text-center"><b @if ($item->status=='Usulan Baru')
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
                          @if ($item->status=='Disetujui')
                              class="badge badge-success"
                          @endif
                          @if ($item->status=='Ditangguhkan')
                              class="badge badge-danger"
                          @endif
                        {{-- @if ($item->status=='Dikunci')
                            class="badge badge-success"
                        @endif --}}
                        >{{$item->status}}</b></td>
                      </tr>
                    @endforeach

                    </tbody>
                  </table>
                </div><!-- table-responsive -->
              </div><!-- card -->
  
              {{-- <div class="card card-body ht-lg-100">
                <div class="media">
                  <span class="tx-color-04"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download wd-60 ht-60"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></span>
                  <div class="media-body mg-l-20">
                    <h6 class="mg-b-10">Download your earnings in CSV format.</h6>
                    <p class="tx-color-03 mg-b-0">Open it in a spreadsheet and perform your own calculations, graphing etc. The CSV file contains additional details, such as the buyer location. </p>
                  </div>
                </div><!-- media -->
              </div> --}}
            </div>
          </div>


    {{-- </div><!-- container --> --}}



</div><!-- content -->  
@endsection