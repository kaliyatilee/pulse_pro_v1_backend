@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Corporate Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Name </h5>
                                        <p>{{ $corporate->name }} </p>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Registration Number </h5>
                                        <p>{{ $corporate->registrationNumber }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Email </h5>
                                        <p>{{ $corporate->email }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Phone </h5>
                                        <p>{{ $corporate->phone}} </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Director Name </h5>
                                        <p>{{ $corporate->directorName }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Registration Fee </h5>
                                        <p>{{ $corporate->registrationfee }} </p>
                                    </div>
                                </div>

                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Payment Acceptance </h5>
                                    <p>{{$corporate->paymentAcceptance == 'online' ? 'Online' : 'Offline'}}</p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Director Id</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                <a target="_blank" href="{{asset('/public/storage/directorid/original')}}/{{$corporate->directorId}}">
                                                    <img style="width: 400px;" src="{{asset('/public/storage/directorid/original')}}/{{$corporate->directorId}}">
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
                                                <a target="_blank" href="{{asset('/public/storage/mousigned/original')}}/{{$corporate->mouSigned}}">
                                                    <u>{{$corporate->mouSigned}}</u>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <a href="{{route('corporatelist')}}" class="button primary">Back</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection