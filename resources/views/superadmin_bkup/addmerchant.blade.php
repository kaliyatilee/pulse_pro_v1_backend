@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Merchant Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif

                        <form method="post" action="{{ route('savemerchant') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{old('name')}}" id="name" name="name" class="form-control input-default @error('name') is-invalid @enderror" placeholder="Merchant Name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{old('registrationNumber')}}" id="registrationNumber" name="registrationNumber" class="form-control input-default @error('registrationNumber') is-invalid @enderror" placeholder="Registration Number">
                                            @error('registrationNumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" value="{{old('email')}}" id="email" name="email" class="form-control input-default @error('email') is-invalid @enderror" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{old('phone')}}" id="phone" name="phone" class="form-control input-default @error('phone') is-invalid @enderror" placeholder="Phone">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{old('directorName')}}" id="directorName" name="directorName" class="form-control input-default @error('directorName') is-invalid @enderror" placeholder="Director Name">
                                            @error('directorName')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{old('registrationfee')}}" id="registrationfee" name="registrationfee" class="form-control input-default @error('registrationfee') is-invalid @enderror" placeholder="Registration Fee">
                                            @error('registrationfee')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control input-default @error('password') is-invalid @enderror" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" id="password-confirm" class="form-control input-default @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="form-label">Payment Acceptance </label>
                                    <select class="form-control default-select" name="paymentAcceptance" id="paymentAcceptance" >
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Director Id</label>
                                        <div class="d-flex flex-wrap">
                                        
                                            <div class="uploadedimg me-3 mb-2" id="image_preview"></div>

                                            <div class="uploadlogo me-3">
                                                <label for="directorId" class="custom-file-upload md-font fw-600 selectlogo addsmupload"><img src="{{asset('/public/assets/img/ic_plus_upld.svg')}}"></label>
                                                <input id="directorId" name="directorId" onchange="preview_image();" type="file" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">MOU Signed</label>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadlogo me-3">
                                                <label for="mouSigned" class="custom-file-upload md-font fw-600 selectlogo addsmupload"><img src="{{asset('/public/assets/img/ic_plus_upld.svg')}}"></label>
                                                <input id="mouSigned" name="mouSigned" type="file" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="button primary">Submit</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
<script>
      // image preview function call  
      function preview_image() {
        var total_file = document.getElementById("directorId").files;
        $('#image_preview').html("<img style='width: 400px;' src='" + URL
            .createObjectURL(event.target.files[0]) + "'>");

    }
</script>