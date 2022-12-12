@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Merchant Information</h4>
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
                            <input type="hidden" value="{{ $merchant->id }}" id="id" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('name') ? old('name') : $merchant->name }}" id="name" name="name" class="form-control input-default @error('name') is-invalid @enderror" placeholder="Merchant Name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('registrationNumber') ? old('registrationNumber') : $merchant->registrationNumber }}" id="registrationNumber" name="registrationNumber" class="form-control input-default @error('registrationNumber') is-invalid @enderror" placeholder="Registration Number">
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
                                        <input type="text" value="{{ old('email') ? old('email') : $merchant->email }}" id="email" name="email" class="form-control input-default @error('email') is-invalid @enderror" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('phone') ? old('phone') : $merchant->phone }}" id="phone" name="phone" class="form-control input-default @error('phone') is-invalid @enderror" placeholder="Phone">
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
                                        <input type="text" value="{{ old('directorName') ? old('directorName') : $merchant->directorName }}" id="directorName" name="directorName" class="form-control input-default @error('directorName') is-invalid @enderror" placeholder="Director Name">
                                            @error('directorName')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('registrationfee') ? old('registrationfee') : $merchant->registrationfee }}" id="registrationfee" name="registrationfee" class="form-control input-default @error('registrationfee') is-invalid @enderror" placeholder="Registration Fee">
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
                                    <label class="form-label">Payment Acceptance </label>
                                    <select class="form-control default-select" name="paymentAcceptance" id="paymentAcceptance" >
                                        <option value="online" {{$merchant->paymentAcceptance == 'online' ? 'selected' : ''}}>Online</option>
                                        <option value="offline" {{$merchant->paymentAcceptance == 'offline' ? 'selected' : ''}}>Offline</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Director Id</label>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                            
                                                
                                            <a download href="../public/storage/directorid/original/{{$merchant->directorId}}"  target="_blank">
                                                <img style="width: 400px;" src="{{asset('/public/storage/directorid/original')}}/{{$merchant->directorId}}">
                                            </a>
                                            </div>

                                            <div class="uploadlogo me-3">
                                                

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
                                                
                                                <input onchange="preview_mou();" id="mouSigned" name="mouSigned" type="file" /><br>
                                                <label for="mouSigned" class="custom-file-upload md-font fw-600 selectlogo addsmupload">
                                                
                                                <p id="oldmou"><a download href="../public/storage/mousigned/original/{{$merchant->mouSigned}}"  target="_blank">
                                                    <img height="20" width="20" src="{{asset('/public/assets/img/PDF_file_icon.svg.png')}}">
                                                </a>{{$merchant->mouSigned}}</p>
                                                </label>
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
      // image preview function call  
      function preview_mou() {
        $('#oldmou').html("");

    }
</script>