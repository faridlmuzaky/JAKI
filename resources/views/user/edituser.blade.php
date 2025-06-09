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
          <a href="{{url('/dashboard')}}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="arrow-left" class="wd-10 mg-r-5"></i> Back</a>
        </div>
      </div>
      
      {{-- Main Content  --}}
      <div class="col-lg-4 col-xl-12 mg-t-10">
        <div class="card">
          <div class="card-header pd-t-20 pd-b-0 bd-b-0">
            <h6 class="mg-b-5">Edit  User</h6>
            <p class="tx-12 tx-color-03 mg-b-0">Merubah User</p>
          </div><!-- card-header -->
          <div class="card-body pd-20">
            <form method="POST" action="/user/{{$userku->id}}/updateuser" class="needs-validation" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" Name="name" class="form-control @error ('name') is-invalid @enderror" id="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Please input your name" value="{{$userku->name}}"> 
                    @error ('name')  
                        <div class="invalid-feedback">  
                        {{$message }}
                        </div> 
                    @enderror
                </div>
                {{-- <div class="form-group">
                  <label for="username">Username</label>
                  
                  <input type="text" Name="username" class="form-control @error ('username') is-invalid @enderror" id="username" placeholder="NIP"  required autocomplete="username" value="{{$userku->username}}">
                    @error ('username')  
                        <div class="invalid-feedback">{{ $errors->first('username') }}</div>  
                    @enderror
                </div> --}}
                <div class="form-group">
                  <label for="telp">Telepon/WA</label>
                  <input type="text" Name="telp" class="form-control @error ('telp') is-invalid @enderror" id="telp" placeholder="contoh : 085759002978" :value="old('telp')" required value="{{$userku->telp}}">
                  @error ('telp')  
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" Name="password" class="form-control @error ('password') is-invalid @enderror" id="password"  required autocomplete="new-password" placeholder="Password must contain alpha numeric characters" value="{{old('password')}}">
                  @error ('password')  
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password_confirmation">Confirm Password</label>
                  <input type="password" Name="password_confirmation" class="form-control @error ('password_confirmation') is-invalid @enderror" id="password_confirmation" required autocomplete="new-password" placeholder="Password Confirmation" value="{{old('password_confirmation')}}">
                  @error ('password_confirmation')  
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group ">
                    <label for="inputPassword3" >Foto Profile</label>
                    {{-- <div class="col-sm-6">  --}}
                         <div class="custom-file">
                            <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file">
                            <label class="custom-file-label" for="customFile">Choose File</label>
                            @error ('file')  
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{$errors->first('file')  }}
                                </div>
                            @enderror
                        </div>
                     
                </div>




                <div>

                    <button type="submit" class="btn btn-warning"><i data-feather="save" class="wd-10 mg-r-5"></i>Update</button>
                </div>
              
            </form>
            
              </form>
            
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      
    </div><!-- container -->
  </div>
</div><!-- content -->  

<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>
@endsection