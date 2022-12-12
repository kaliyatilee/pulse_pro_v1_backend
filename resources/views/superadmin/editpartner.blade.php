@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Partner Information</h4>
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

                           
                            <form method="post" action="{{ route('savepartner') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $partner->id }}" id="id" name="id">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('name') ? old('name') : $partner->name }}" id="name" name="name" class="form-control input-default @error('name') is-invalid @enderror" placeholder="Partner Name">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('partnerTradingName') ? old('partnerTradingName') : $partner->partnerTradingName }}" id="partnerTradingName" name="partnerTradingName" class="form-control input-default @error('partnerTradingName') is-invalid @enderror" placeholder="Partner Trading Name">
                                                    @error('partnerTradingName')
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
                                                <input type="email" value="{{ old('email') ? old('email') : $partner->email }}" id="email" name="email" class="form-control input-default @error('email') is-invalid @enderror" placeholder="Email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('phone') ? old('phone') : $partner->phone }}" id="phone" name="phone" class="form-control input-default @error('phone') is-invalid @enderror" placeholder="Phone">
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
                                                <input type="text" value="{{ old('businessType') ? old('businessType') : $partner->businessType }}" id="businessType" name="businessType" class="form-control input-default @error('businessType') is-invalid @enderror" placeholder="Business Type">
                                                    @error('businessType')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('partnerTradingDetails') ? old('partnerTradingDetails') : $partner->partnerTradingDetails }}" id="partnerTradingDetails" name="partnerTradingDetails" class="form-control input-default @error('partnerTradingDetails') is-invalid @enderror" placeholder="Partner Trading Details">
                                                    @error('partnerTradingDetails')
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
                                                <input type="text" value="{{ old('propertyNumber') ? old('propertyNumber') : $partner->propertyNumber }}" id="propertyNumber" name="propertyNumber" class="form-control input-default @error('propertyNumber') is-invalid @enderror" placeholder="Property Number">
                                                    @error('propertyNumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('streetName') ? old('streetName') : $partner->streetName }}" id="streetName" name="streetName" class="form-control input-default @error('streetName') is-invalid @enderror" placeholder="Street Name">
                                                    @error('streetName')
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
                                                <input type="text" value="{{ old('suburb') ? old('suburb') : $partner->suburb }}" id="suburb" name="suburb" class="form-control input-default @error('suburb') is-invalid @enderror" placeholder="suburb">
                                                    @error('suburb')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('bankName') ? old('bankName') : $partner->bankName }}" id="bankName" name="bankName" class="form-control input-default @error('bankName') is-invalid @enderror" placeholder="Street Name">
                                                    @error('bankName')
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
                                                <input type="text" value="{{ old('accountNumber') ? old('accountNumber') : $partner->accountNumber }}" id="accountNumber" name="accountNumber" class="form-control input-default @error('accountNumber') is-invalid @enderror" placeholder="Account Number">
                                                    @error('accountNumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('branchName') ? old('branchName') : $partner->branchName }}" id="branchName" name="branchName" class="form-control input-default @error('branchName') is-invalid @enderror" placeholder="Branch Name">
                                                    @error('branchName')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{ old('branchCode') ? old('branchCode') : $partner->branchCode }}" id="branchCode" name="branchCode" class="form-control input-default @error('branchCode') is-invalid @enderror" placeholder="Branch Code">
                                                    @error('branchCode')
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
                                                <label class="form-label">Director Id</label>
                                                <div class="d-flex flex-wrap">
                                                    <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                    <a download href="../public/storage/directorid/original/{{$partner->directorId}}"  target="_blank">
                                                        <img style="width: 400px;" src="{{asset('/public/storage/directorid/original')}}/{{$partner->directorId}}">
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
                                                <label class="form-label">CR14 form</label>
                                                <div class="d-flex flex-wrap">
                                                    <div class="uploadlogo me-3">
                                                        <label for="CR14form" class="custom-file-upload md-font fw-600 selectlogo addsmupload"><img src="{{asset('/public/assets/img/ic_plus_upld.svg')}}"></label>
                                                        <input onchange="preview_mou();" id="CR14form" name="CR14form" type="file" /><br><p id="oldmou">
                                                        <a download href="../public/storage/CR14form/original/{{$partner->CR14form}}"  target="_blank">
                                                        <img height="20" width="20" src="{{asset('/public/assets/img/PDF_file_icon.svg.png')}}">        
                                                        {{$partner->CR14form}}
                                                        </a>
                                                    
                                                    </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Certificate Of Incorporation</label>
                                                <div class="d-flex flex-wrap">
                                                    <div class="uploadlogo me-3">
                                                        <label for="certificateOfIncorporation" class="custom-file-upload md-font fw-600 selectlogo addsmupload"></label>
                                                        <input onchange="preview_mou();" id="certificateOfIncorporation" name="certificateOfIncorporation" type="file" /><br><p id="oldmou">
                                                            
                                                        <a download href="../public/storage/certificateOfIncorporation/original/{{$partner->certificateOfIncorporation}}"  target="_blank">
                                                        <img height="20" width="20" src="{{asset('/public/assets/img/PDF_file_icon.svg.png')}}">
                                                        {{$partner->certificateOfIncorporation}}
                                                        </a>
                                                    </p>
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