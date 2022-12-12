@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Merchant Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Name </h5>
                                        <p>{{ $merchant->name }} </p>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Registration Number </h5>
                                        <p>{{ $merchant->registrationNumber }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Email </h5>
                                        <p>{{ $merchant->email }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Phone </h5>
                                        <p>{{ $merchant->phone}} </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Director Name </h5>
                                        <p>{{ $merchant->directorName }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Registration Fee </h5>
                                        <p>{{ $merchant->registrationfee }} </p>
                                    </div>
                                </div>

                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Payment Acceptance </h5>
                                    <p>{{$merchant->paymentAcceptance == 'online' ? 'Online' : 'Offline'}}</p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Director Id</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                            <a download href="../public/storage/directorid/original/{{$merchant->directorId}}"  target="_blank">
                                                    <img style="width: 400px;" src="{{asset('/public/storage/directorid/original')}}/{{$merchant->directorId}}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">MOU Signed</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadlogo me-3">
                                            <a download href="../public/storage/mousigned/original/{{$merchant->mouSigned}}"  target="_blank">
                                                    <img height="20" width="20" src="{{asset('/public/assets/img/PDF_file_icon.svg.png')}}">
                                                <u>{{$merchant->mouSigned}}</u>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <a href="{{route('merchantlist')}}" class="button primary">Back</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection